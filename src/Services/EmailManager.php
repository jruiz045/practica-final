<?php

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
    public function enviarCorreosSolicitudPresupuestoAComerciales(Budget $budget, BudgetRepository $budgetRepository): boolean {
        
        $from_email = 'jaimeruizperez@gmail.com';
        
        $role = 'ROLE_SALES';
        $sales_user_list = $budgetRepository->findByRole($role);
        
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
        
        foreach($sales_user_list as $salesUser) {
            
            $mailer = (new Email())
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
    public function enviarCorreosSolicitudPresupuestoASolicitante(Budget $budget): boolean {
        
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
        
        $mailer = (new Email())
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
    public function enviarCorreosPresupuestoAprobadoSolicitante(SolicitudPresupuesto $solicitud): boolean {
        
    }
    
    /**
     * Envía un correo al jefe de proyecto del presupuesto
     * indicando que se ha aprobado el presupuesto
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreosPresupuestoAprobadoJefesProyecto(SolicitudPresupuesto $solicitud): boolean {
        
    }
    
    /**
     * Envía un correo al jefe de proyecto
     * indicando que se ha completado la tarea
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreoTareaTerminadaATecnico(Task $task): boolean {
        
    }
    
    /**
     * Envía un correo al técnico
     * indicando que se ha asociado a un técnico una tarea
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreosTecnicoAsociadoATarea(Task $task): boolean {
        
    }
    
    /**
     * Envía un correo al técnico
     * indicando que se ha asociado a un técnico una tarea
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreosCambioAsignacionProyecto(Project $project): boolean {
        
    }
    
    /**
     * Envía un correo al jefe de proyecto
     * indicando que ha cambiado el estado de un proyecto
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreoCambioEstadoProyectoASolicitante(Project $project): boolean {
        $budget = $project->getBudget();
        $client = $budget->getUser();
    }
    
    /**
     * Envía un correos a los técnicos del proyecto
     * indicando que ha cambiado el estado de un proyecto
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreosCambioEstadoProyectoATecnicos(Project $project): boolean {
        $task_list = $project->getTasks();
        foreach ($task_list as $task) {
            $technician = $task->getUser();
        }
    }
    
    /**
     * Envía un correo al jefe de proyecto
     * indicando que una tarea ha sido completada
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreoTareaFinalizadaAJefesProyecto(Task $task): boolean {
        $proyecto = $task->getProject();
        $chiefProject = $proyecto->getUser();
    }

}
