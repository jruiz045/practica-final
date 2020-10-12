<?php

/**
 * Servicio que gestiona la el panel del jefe de proyectos
 *
 */
class ChiefProjectManager {
    public function __contruct() {
        
    }
    
    /**
     * Mostrar la lista de proyectos en marcha  
     */
    public function viewWorkingProjetList() :void {
        
    }
    
    /**
     * Mostrar el histórico de proyectos  
     */
    public function viewProjectHistory() : void {
        
    }
    
    /**
     * Ascociar técnico a un proyecto en marcha
    */
    public function addTechniciamToWorkingProject(User $technician, Project $project1) : void {
        
    }
    
    /**
     * Añadir tarea a un proyecto
    */
    public function createTaskInProject(Task $task, Project $project) : void {
        
    }
    
    /**
     * Añadir un técnico a una tarea del proyecto
    */
    public function addTechnicianToTask(User $technician, Task $task, Project $project) : void {
        
    }
    
    /**
     * Intercambiar técnicos en una tarea
    */
    public function swapTechnicianInTask(User $formerTechnician, User $newTechnician, Task $task) : void {
        
    }
    
    /**
     * Camiar el estado del proyecto
    */
    public function changeProjectStatus(Status $status, Project $project) {
        
    }
}
