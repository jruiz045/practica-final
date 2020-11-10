<?php

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Translation\TranslatorInterface;
use App\Repository\UserRepository;
use App\Repository\AppRepository;
use App\Repository\FeatureRepository;

/**
 * Servicio que gestiona el envío de correo
 *
 */
class EmailManager {

    public function __construct() {
        
    }
    
    /**
     * Envía un correo a los comerciales con la 
     * información de la nueva solicitud
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreosSolicitudPresupuestoAComerciales(Budget $budgetRequest, UserRepository $userRepository, AppRepository $appRepository, FeatureRepository $fetureRepository, TranslatorInterface $translator): boolean {
        
        $client = $budgetRequest->getUser(); 
        $app_id_list = $budgetRequest->getAppId();
        $feature_id_list = $budgetRequest->getFeatureId();
        $selected_apps = $selected_features = array();
        
        foreach($app_id_list as $appid) { $selected_apps[] = $appRepository->find($appid)->getDescription(); }
        foreach($feature_id_list as $featureid) { $selected_features[] = $fetureRepository->find($featureid)->getDescription(); }
        
        $from = 'admin@admin.es';
        $subject = $translator->trans('New Budget Request received: %budgetid%', array('%budgetid%' => $budgetRequest->getId()));
        $message = '<p>'.$translator->trans('Username: %username%', array('%username%' => $client->getName())).'</p>'
                 . '<p>'.$translator->trans('User email: %useremail%', array('%useremail%' => $client->getEmail())).'</p>'
                 . '<p>'.$translator->trans('Selected app list: %applist%', array('%applist%' => implode(",", $selected_apps))).'</p>'
                 . '<p>'.$translator->trans('Selected feature list: %featurelist%', array('%featurelist%' => implode(",", $selected_features))).'</p>'
                 . '<p>'.$translator->trans('Budget amount: %budgetamount%', array('%budgetamount%' => $budgetRequest->getPrice())).'</p>';
        
        $email = (new Email())
                ->from($from)
                ->subject($subject)
                ->html($message);
        
        $sales_user_list = $userRepository->findByRole('ROLE_SALES');
        foreach($sales_user_list as $salesUser) {
            $email->addTo($salesUser->getEmail());
        }
        
        $transport = Transport::fromDsn('smtp://localhost');
        $mailer = new Mailer($transport);
        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            return false;
        }
        return true;
    }

    /**
     * Envía un correo al solicitante del presupuesto indicando  
     * que se ha recibido la solicitud
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreoSolicitudPresupuestoASolicitante(Budget $budgetRequest, AppRepository $appRepository, FeatureRepository $fetureRepository, TranslatorInterface $translator): boolean {
        
        $client = $budgetRequest->getUser();
        $appid_list = $budgetRequest->getAppId();
        $featureid_list = $budgetRequest->getFeatureId();
        $selected_apps = $selected_features = array();
        
        foreach($appid_list as $appid) { $selected_apps[] = $appRepository->find($appid)->getDescription(); }
        foreach($featureid_list as $featureid) { $selected_features[] = $fetureRepository->find($featureid)->getDescription(); }
        
        $from = 'admin@admin.es';
        $subject = $translator->trans('Budget Request: %budgetid%', array('%budgetid%' => $budgetRequest->getId()));
        $message = '<p>'.$translator->trans('Your app list: %applist%', array('%applist%' => implode(",", $selected_apps))).'</p>'
                 . '<p>'.$translator->trans('Your feature list: %featurelist%', array('%featurelist%' => implode(",", $selected_features))).'</p>'
                 . '<p>'.$translator->trans('Budget amount: %budgetprice%', array('%budgetprice%' => $budgetRequest->getPrice())).'</p>'
                 . '<p>'.$translator->trans('The budget we send you here is not final, but illustrative').'</p>';
        
        $email = (new Email())
                ->from($from)
                ->to($client->getEmail())
                ->subject($subject)
                ->html($message);
        
        $transport = Transport::fromDsn('smtp://localhost');
        $mailer = new Mailer($transport);
        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            return false;
        }
        return true;
    }

    /**
     * Envía un correo al solicitante del presupuesto
     * indicando que se ha aprobado el presupuesto
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreoPresupuestoAprobadoSolicitante(Budget $budgetRequest, AppRepository $appRepository, FeatureRepository $fetureRepository, TranslatorInterface $translator): boolean {
        
        $client = $budgetRequest->getUser();
        $appid_list = $budgetRequest->getAppId();
        $featureid_list = $budgetRequest->getFeatureId();
        $selected_apps = $selected_features = array();
    
        foreach($appid_list as $appid) { $selected_apps[] = $appRepository->find($appid)->getDescription(); }
        foreach($featureid_list as $featureid) { $selected_features[] = $fetureRepository->find($featureid)->getDescription(); }
         
        $project_link = 'project/show/'.hash('ripemd160', $budgetRequest->getProject()->getId());
        
        $from = 'admin@admin.es';
        $subject = $translator->trans('Budget Accepted: %budgetid%', array('%budgetid%' => $budgetRequest->getId()));
        $message = '<p>'.$translator->trans('Your app list: %applist%', array('%applist%' => implode(",", $selected_apps))).'</p>'
                 . '<p>'.$translator->trans('Your feature list: %featurelist%', array('%featurelist%' => implode(",", $selected_features))).'</p>'
                 . '<p>'.$translator->trans('Budget amount: %budgetprice%', array('%budgetprice%' => $budgetRequest->getPrice())).'</p>'
                 . '<a href="'.$project_link.'">'.$translator->trans('Project Info').'</a>';
        
        $email = (new Email())
                ->from($from)
                ->to($client->getEmail())
                ->subject($subject)
                ->html($message);
        
        $transport = Transport::fromDsn('smtp://localhost');
        $mailer = new Mailer($transport);
        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            return false;
        }
        return true;
    }
    
    /**
     * Envía un correo al jefe de proyecto del presupuesto
     * indicando que se ha aprobado el presupuesto
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreosPresupuestoAprobadoJefesProyecto(Budget $budgetRequest, UserRepository $userRepository, AppRepository $appRepository, FeatureRepository $fetureRepository, TranslatorInterface $translator): boolean {
        
        $appid_list = $budgetRequest->getAppId();
        $featureid_list = $budgetRequest->getFeatureId();
        $selected_apps = $selected_features = array();
    
        foreach($appid_list as $appid) { $selected_apps[] = $appRepository->find($appid)->getDescription(); }
        foreach($featureid_list as $featureid) { $selected_features[] = $fetureRepository->find($featureid)->getDescription(); }
        
        $from = 'admin@admin.es';
        $subject = $translator->trans('Budget Accepted: %budgetid%', array('%budgetid%' => $budgetRequest->getId()));
        $message = '<p>'.$translator->trans('Selected app list: %applist%', array('%applist%' => implode(",", $selected_apps))).'</p>'
                 . '<p>'.$translator->trans('Selected feature list: %featurelist%', array('%featurelist%' => implode(",", $selected_features))).'</p>'
                 . '<p>'.$translator->trans('Budget amount: %budgetfinalprice%', array('%budgetfinalprice%' => $budgetRequest->getFinalPrice())).'</p>'
                 . '<p>'.$translator->trans('Deadline: %deliverydate%', array('%deliverydate%' => $budgetRequest->getDeliveryDate())).'</p>';
        
        $email = (new Email())
                ->from($from)
                ->subject($subject)
                ->html($message);
        
        $chief_project_user_list = $userRepository->findByRole('ROLE_CHIEF_PROJECT');
        foreach($chief_project_user_list as $chiefProject) {
            $email->addTo($chiefProject->getEmail());
        }
        
        $transport = Transport::fromDsn('smtp://localhost');
        $mailer = new Mailer($transport);
        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            return false;
        }
        return true;
    }
    
    /**
     * Envía un correo al técnico
     * indicando que se ha asociado a un técnico una tarea
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreoTecnicoAsociadoATarea(Task $task, TranslatorInterface $translator): boolean {
        
        $technician = $task->getUser();
        
        $from = 'admin@admin.es';
        $subject = $translator->trans('Task %taskid% assigned', array('%taskid%' => $task->getId()));
        $message = '<p>'.$translator->trans('You\'ve been assigned the task %taskid%', array('%taskid%' => $task->getId())).'</p>'
                 . '<p>'.$translator->trans('Task description: %taskdescription%', array('%taskdescription%' => $task->getDescription())).'</p>';
        
        $email = (new Email())
                ->from($from)
                ->to($technician->getEmail())
                ->subject($subject)
                ->html($message);
        
        $transport = Transport::fromDsn('smtp://localhost');
        $mailer = new Mailer($transport);
        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            return false;
        }
        return true;
    }
    
    /**
     * Envía un correo al jefe de proyecto
     * indicando que ha cambiado el estado de un proyecto
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreoCambioEstadoProyectoASolicitante(Project $project, TranslatorInterface $translator): boolean {
        
        $budget = $project->getBudget();
        $client = $budget->getUser();
        
        $from = 'admin@admin.es';
        $subject = $translator->trans('Project %projectid% changed to %projectstate%', array('%projectid%' => $project->getId(), '%projectstate%' => $project->getState()));
        $message = '<p>'.$translator->trans('The state of the project %projectid% changed to %projectstate%', array('%projectid%' => $project->getId(), '%projectstate%' => $project->getState())).'</p>'
                 . '<p>'.$translator->trans('Project description: %projectdescription%', array('%taskdescription%' => $project->getDescription())).'</p>';
        
        $email = (new Email())
                ->from($from)
                ->to($client->getEmail())
                ->subject($subject)
                ->html($message);
        
        $transport = Transport::fromDsn('smtp://localhost');
        $mailer = new Mailer($transport);
        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            return false;
        }
        return true;
    }
    
    /**
     * Envía un correos a los técnicos del proyecto
     * indicando que ha cambiado el estado de un proyecto
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreosCambioEstadoProyectoATecnicos(Project $project, TranslatorInterface $translator): boolean {
       
        $from = 'admin@admin.es';
        $subject = $translator->trans('Project %projectid% changed to %projectstate%', array('%projectid%' => $project->getId(), '%projectstate%' => $project->getState()));
        $message = '<p>'.$translator->trans('The state of the project %projectid% changed to %projectstate%', array('%projectid%' => $project->getId(), '%projectstate%' => $project->getState())).'</p>'
                 . '<p>'.$translator->trans('Project description: %projectdescription%', array('%taskdescription%' => $project->getDescription())).'</p>';
        $email = (new Email())
                ->from($from)
                ->subject($subject)
                ->html($message);
        
        $task_list = $project->getTasks();  
        foreach ($task_list as $task) {
            $technician = $task->getUser();
            $email->addTo($technician->getEmail());
        }
        
        $transport = Transport::fromDsn('smtp://localhost');
        $mailer = new Mailer($transport);
        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            return false;
        }
        return true;
    }
    
    /**
     * Envía un correo al jefe de proyecto
     * indicando que una tarea ha sido completada
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreosTareaFinalizadaAJefesProyecto(Task $task, UserRepository $userRepository, TranslatorInterface $translator): boolean {

        
        $from = 'admin@admin.es';
        $subject = $translator->trans('Task %taskid% finished', array('%taskid%' => $task->getId()));
        $message = '<p>'.$translator->trans('The task %taskid% has been finished', array('%taskid%' => $task->getId())).'</p>'
                 . '<p>'.$translator->trans('Task description: %taskdescription%', array('%taskdescription%' => $task->getDescription())).'</p>';
        
        $email = (new Email())
                    ->from($from)
                    ->subject($subject)
                    ->html($message);
        
        $chief_project_user_list = $userRepository->findByRole('ROLE_CHIEF_PROJECT');
        foreach($chief_project_user_list as $chiefProject) {   
            $email->addTo($chiefProject->getEmail());
        }
        
        $transport = Transport::fromDsn('smtp://localhost');
        $mailer = new Mailer($transport);
        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            return false;
        }
        return true;
    }

}
