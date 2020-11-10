<?php

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
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
    public function enviarCorreosSolicitudPresupuestoAComerciales(Budget $budgetRequest, UserRepository $userRepository, AppRepository $appRepository, FeatureRepository $fetureRepository): boolean {
        
        $client = $budgetRequest->getUser(); 
        $app_id_list = $budgetRequest->getAppId();
        $feature_id_list = $budgetRequest->getFeatureId();
        $selected_apps = $selected_features = array();
        
        foreach($app_id_list as $appid) { $selected_apps[] = $appRepository->find($appid)->getDescription(); }
        foreach($feature_id_list as $featureid) { $selected_features[] = $fetureRepository->find($featureid)->getDescription(); }
        
        $message = '<p>Username: '.$client->getName().'</p>'
                 . '<p>User email: '.$client->getEmail().'</p>'
                 . '<p>Selected app list: '.implode(",", $selected_apps).'</p>'
                 . '<p>Selected feature list: '.implode(",", $selected_features).'</p>'
                 . '<p>Budget amount: '.$budgetRequest->getPrice().'</p>';
        $subject = 'New Budget Request received: '. $budgetRequest->getId();
        
        $from = 'jaimeruizperez@gmail.com';
        $transport = Transport::fromDsn('smtp://localhost');
        $mailer = new Mailer($transport);
        $email = (new Email())
                ->from($from)
                ->subject($subject)
                ->html($message);
        
        $sales_user_list = $userRepository->findByRole('ROLE_SALES');
        foreach($sales_user_list as $salesUser) {
            $email->addTo($salesUser->getEmail());
        }
        
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
    public function enviarCorreoSolicitudPresupuestoASolicitante(Budget $budgetRequest, AppRepository $appRepository, FeatureRepository $fetureRepository): boolean {
        
        $appid_list = $budgetRequest->getAppId();
        $featureid_list = $budgetRequest->getFeatureId();
        $app_list_text = $feature_list_text = '';
        $selected_apps = $selected_features = array();
        
        foreach($appid_list as $appid) { $selected_apps[] = $appRepository->find($appid)->getDescription(); }
        foreach($featureid_list as $featureid) { $selected_features[] = $fetureRepository->find($featureid)->getDescription(); }
        
        $client = $budgetRequest->getUser();
        $app_list_text .= implode(",", $selected_apps);
        $feature_list_text .= implode(",", $selected_features);
        $approximate_budget_amount = 'Budget amount: '.$budgetRequest->getPrice();
        
        $from_email = 'jaimeruizperez@gmail.com';
        $transport = Transport::fromDsn('smtp://localhost');
        $mailer = new Mailer($transport);
        $email = (new Email())
                ->from($from_email)
                ->to($client->getEmail())
                ->subject('Budget Request: '. $budgetRequest->getId())
                ->html('<p>Your feature list: '.$app_list_text.'</p>'
                     . '<p>Your app list: '.$feature_list_text.'</p>'
                     . '<p>'.$approximate_budget_amount.'</p>'
                     . '<p>The budget we send you here is not final, but illustrative</p>');
        
        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
    
        }
    }

    /**
     * Envía un correo al solicitante del presupuesto
     * indicando que se ha aprobado el presupuesto
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreoPresupuestoAprobadoSolicitante(Budget $budgetRequest, AppRepository $appRepository, FeatureRepository $fetureRepository): boolean {
        $from_email = 'jaimeruizperez@gmail.com';
        
        $client = $budgetRequest->getUser();
        
        $appid_list = $budgetRequest->getAppId();
        $app_list_text = 'Your app list: ';
        $selected_apps = array();
        foreach($appid_list as $appid) {
            $app = $appRepository->find($appid); 
            $selected_apps[] = $app->getDescription();
        }
        $app_list_text .= implode(",", $selected_apps);

        $featureid_list = $budgetRequest->getFeatureId();
        $feature_list_text = 'Your feature list: ';
        $selected_features = array();
        foreach($featureid_list as $featureid) {
            $feature = $fetureRepository->find($featureid); 
            $selected_features[] = $feature->getDescription();
        }
        $feature_list_text .= implode(",", $selected_features);
        
        $budget_amount = 'Budget amount: '.$budgetRequest->getFinalPrice();
        
        $budgetAssociatedProject = $budgetRequest->getProject();
        $project_link = 'project/show/'.hash('ripemd160', $budgetAssociatedProject->getId());
        
        $transport = Transport::fromDsn('smtp://localhost');
        $mailer = new Mailer($transport);
        
        $email = (new Email())
                ->from($from_email)
                ->to($client->getEmail())
                ->subject('Budget Accepted: '. $budgetRequest->getId())
                ->html('<p>'.$app_list_text.'</p>'
                     . '<p>'.$feature_list_text.'</p>'
                     . '<p>'.$budget_amount.'</p>'
                     . '<a href="'.$project_link.'">Project Info</a>');
        
        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
    
        }
    }
    
    /**
     * Envía un correo al jefe de proyecto del presupuesto
     * indicando que se ha aprobado el presupuesto
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreosPresupuestoAprobadoJefesProyecto(Budget $budgetRequest, UserRepository $userRepository, AppRepository $appRepository, FeatureRepository $fetureRepository): boolean {
        
        $from_email = 'jaimeruizperez@gmail.com';
        
        $appid_list = $budgetRequest->getAppId();
        $app_list_text = 'Your app list: ';
        $selected_apps = array();
        foreach($appid_list as $appid) {
            $app = $appRepository->find($appid);
            $selected_apps[] = $app->getDescription();
        }
        $app_list_text .= implode(",", $selected_apps);

        $featureid_list = $budgetRequest->getFeatureId();
        $feature_list_text = 'Your feature list: ';
        $selected_features = array();
        foreach($featureid_list as $featureid) {
            $feature = $fetureRepository->find($featureid); 
            $selected_features[] = $feature->getDescription();
        }
        $feature_list_text .= implode(",", $selected_features);
        
        $budget_amount = 'Budget amount: '.$budgetRequest->getFinalPrice();
        
        $delivery_date = 'Deadline: '.$budgetRequest->getDeliveryDate();
        
        $chief_project_user_list = $userRepository->findByRole('ROLE_CHIEF_PROJECT');
        
        $transport = Transport::fromDsn('smtp://localhost');
        $mailer = new Mailer($transport);
        
        foreach($chief_project_user_list as $chiefProject) {
            $email = (new Email())
                ->from($from_email)
                ->to($chiefProject->getEmail())
                ->subject('Budget Accepted: '. $budgetRequest->getId())
                ->html('<p>'.$app_list_text.'</p>'
                     . '<p>'.$feature_list_text.'</p>'
                     . '<p>'.$budget_amount.'</p>'
                     . '<p>'.$delivery_date.'</p>');
        
            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
    
            }
        }
    }
    
    /**
     * Envía un correo al técnico
     * indicando que se ha asociado a un técnico una tarea
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreoTecnicoAsociadoATarea(Task $task): boolean {
        $from_email = 'jaimeruizperez@gmail.com';
        
        $technician = $task->getUser();
        
        $transport = Transport::fromDsn('smtp://localhost');
        $mailer = new Mailer($transport);
        
        $email = (new Email())
                ->from($from_email)
                ->to($technician->getEmail())
                ->subject('You\'ve been assigned the following task: '. $task->getDescription())
                ->html('<p>You\'ve been assigned the following task: '. $task->getDescription().'</p>');
        
        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
    
        }
    }
    
    /**
     * Envía un correo al jefe de proyecto
     * indicando que ha cambiado el estado de un proyecto
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreoCambioEstadoProyectoASolicitante(Project $project): boolean {
        $from_email = 'jaimeruizperez@gmail.com';
        
        $budget = $project->getBudget();
        $client = $budget->getUser();
        
        $transport = Transport::fromDsn('smtp://localhost');
        $mailer = new Mailer($transport);
        
        $email = (new Email())
                ->from($from_email)
                ->to($client->getEmail())
                ->subject('Project stratus changed to: '. $project->getState())
                ->html('<p>The status of the project '.$project->getId().' changed to'.$project->getState().'</p>');
        
        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
    
        }
    }
    
    /**
     * Envía un correos a los técnicos del proyecto
     * indicando que ha cambiado el estado de un proyecto
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreosCambioEstadoProyectoATecnicos(Project $project): boolean {
        $from_email = 'jaimeruizperez@gmail.com';
        
        $task_list = $project->getTasks();
        
        $transport = Transport::fromDsn('smtp://localhost');
        $mailer = new Mailer($transport);
        
        foreach ($task_list as $task) {
            $technician = $task->getUser();
            
            $email = (new Email())
                ->from($from_email)
                ->to($technician->getEmail())
                ->subject('Project '.$project->getId().' stratus changed to: '. $project->getState())
                ->html('<p>The status of the project '.$project->getId().' changed to'.$project->getState().'</p>');
        
            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
    
            }
        }
    }
    
    /**
     * Envía un correo al jefe de proyecto
     * indicando que una tarea ha sido completada
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreosTareaFinalizadaAJefesProyecto(Task $task, UserRepository $userRepository): boolean {

        
        $from_email = 'jaimeruizperez@gmail.com';
        
        $chief_project_user_list = $userRepository->findByRole('ROLE_CHIEF_PROJECT');
        
        $transport = Transport::fromDsn('smtp://localhost');
        $mailer = new Mailer($transport);
        
        foreach($chief_project_user_list as $chiefProject) {   
        
            $email = (new Email())
                    ->from($from_email)
                    ->to($chiefProject->getEmail())
                    ->subject('Task: '. $task->getDescription().' finished')
                    ->html('<p>Task: '. $task->getDescription().' finished'.'</p>');
        
            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
    
            }
        }
    }

}
