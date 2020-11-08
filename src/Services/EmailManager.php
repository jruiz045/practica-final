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
    public function enviarCorreosSolicitudPresupuestoAComerciales(SolicitudPresupuesto $solicitud): boolean {
        
    }

    /**
     * Envía un correo al solicitante del presupuesto indicando  
     * que se ha recibido la solicitud
     *
     * Devuelve true si todo ha ido bien o false si 
     * no se ha podido enviar el correo
     */
    public function enviarCorreosSolicitudPresupuestoASolicitante(SolicitudPresupuesto $solicitud): boolean {
        
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
    public function enviarCorreoTareaFinalizadaAJefeProyecto(Task $task): boolean {
        $proyecto = $task->getProject();
        $chiefProject = $proyecto->getUser();
    }

}
