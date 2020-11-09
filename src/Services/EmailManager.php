<?php

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
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
    public function enviarCorreosSolicitudPresupuestoAComerciales(Budget $budget, UserRepository $userRepository): boolean {
        
        $from_email = 'jaimeruizperez@gmail.com';
        
        $role = 'ROLE_SALES';
        $sales_user_list = $userRepository->findByRole($role);
        
        $client = $budget->getUser();
        
        $appid_list = $budget->getAppId();
        $app_list_text = 'Your app list: ';
        $selected_apps = array();
        foreach($appid_list as $appid) {
            $app = new App($appid); 
            $selected_apps[] = $app->getDescription();
        }
        $app_list_text .= implode(",", $selected_apps);

        $featureid_list = $budget->getFeatureId();
        $feature_list_text = 'Your feature list: ';
        $selected_features = array();
        foreach($featureid_list as $featureid) {
            $feature = new Feature($featureid); 
            $selected_features[] = $feature->getDescription();
        }
        $feature_list_text .= implode(",", $selected_features);
        
        $approximate_budget_amount = 'Budget amount: '.$budget->getPrice();
        
        $transport = Transport::fromDsn('smtp://localhost');
        $mailer = new Mailer($transport);
        
        foreach($sales_user_list as $salesUser) {
            $email = (new Email())
                ->from($from_email)
                ->to($salesUser->getEmail())
                ->subject('New Budget Request received: '. $budget->getId())
                ->html('<p>Username: '.$client->getName().'</p>'
                     . '<p>User email: '.$client->getEmail().'</p>'
                     . '<p>'.$app_list_text.'</p>'
                     . '<p>'.$feature_list_text.'</p>'
                     . '<p>'.$approximate_budget_amount.'</p>');
        
            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
    
            }
        }

    }

    /**
     * Envía un correo al solicitante del presupuesto indicando  
     * que se ha recibido la solicitud
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreoSolicitudPresupuestoASolicitante(Budget $budget): boolean {
        
        $from_email = 'jaimeruizperez@gmail.com';
        
        $client = $budget->getUser();
        
        $appid_list = $budget->getAppId();
        $app_list_text = 'Your app list: ';
        $selected_apps = array();
        foreach($appid_list as $appid) {
            $app = new App($appid); 
            $selected_apps[] = $app->getDescription();
        }
        $app_list_text .= implode(",", $selected_apps);

        $featureid_list = $budget->getFeatureId();
        $feature_list_text = 'Your feature list: ';
        $selected_features = array();
        foreach($featureid_list as $featureid) {
            $feature = new Feature($featureid); 
            $selected_features[] = $feature->getDescription();
        }
        $feature_list_text .= implode(",", $selected_features);
        
        $approximate_budget_amount = 'Budget amount: '.$budget->getPrice();
        
        $transport = Transport::fromDsn('smtp://localhost');
        $mailer = new Mailer($transport);
        
        $email = (new Email())
                ->from($from_email)
                ->to($client->getEmail())
                ->subject('Budget Request: '. $budget->getId())
                ->html('<p>'.$app_list_text.'</p>'
                     . '<p>'.$feature_list_text.'</p>'
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
    public function enviarCorreoPresupuestoAprobadoSolicitante(Budget $budget): boolean {
        $from_email = 'jaimeruizperez@gmail.com';
        
        $client = $budget->getUser();
        
        $appid_list = $budget->getAppId();
        $app_list_text = 'Your app list: ';
        $selected_apps = array();
        foreach($appid_list as $appid) {
            $app = new App($appid); 
            $selected_apps[] = $app->getDescription();
        }
        $app_list_text .= implode(",", $selected_apps);

        $featureid_list = $budget->getFeatureId();
        $feature_list_text = 'Your feature list: ';
        $selected_features = array();
        foreach($featureid_list as $featureid) {
            $feature = new Feature($featureid); 
            $selected_features[] = $feature->getDescription();
        }
        $feature_list_text .= implode(",", $selected_features);
        
        $budget_amount = 'Budget amount: '.$budget->getFinalPrice();
        
        $budgetAssociatedProject = $budget->getProject();
        $project_link = 'project/show/'.hash('ripemd160', $budgetAssociatedProject->getId());
        
        $transport = Transport::fromDsn('smtp://localhost');
        $mailer = new Mailer($transport);
        
        $email = (new Email())
                ->from($from_email)
                ->to($client->getEmail())
                ->subject('Budget Accepted: '. $budget->getId())
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
    public function enviarCorreosPresupuestoAprobadoJefesProyecto(Budget $budget, UserRepository $userRepository): boolean {
        
        $from_email = 'jaimeruizperez@gmail.com';
        
        $appid_list = $budget->getAppId();
        $app_list_text = 'Your app list: ';
        $selected_apps = array();
        foreach($appid_list as $appid) {
            $app = new App($appid); 
            $selected_apps[] = $app->getDescription();
        }
        $app_list_text .= implode(",", $selected_apps);

        $featureid_list = $budget->getFeatureId();
        $feature_list_text = 'Your feature list: ';
        $selected_features = array();
        foreach($featureid_list as $featureid) {
            $feature = new Feature($featureid); 
            $selected_features[] = $feature->getDescription();
        }
        $feature_list_text .= implode(",", $selected_features);
        
        $budget_amount = 'Budget amount: '.$budget->getFinalPrice();
        
        $delivery_date = 'Deadline: '.$budget->getDeliveryDate();
        
        $role = 'ROLE_CHIEF_PROJECT';
        $chief_project_user_list = $userRepository->findByRole($role);
        
        $transport = Transport::fromDsn('smtp://localhost');
        $mailer = new Mailer($transport);
        
        foreach($chief_project_user_list as $chiefProject) {
            $email = (new Email())
                ->from($from_email)
                ->to($chiefProject->getEmail())
                ->subject('Budget Accepted: '. $budget->getId())
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
        
        $role = 'ROLE_CHIEF_PROJECT';
        $chief_project_user_list = $userRepository->findByRole($role);
        
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
