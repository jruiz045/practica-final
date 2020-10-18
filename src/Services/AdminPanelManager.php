<?php

/**
 * Servicio que gestiona la el panel de administración
 *
 */

class AdminPanelManager {
    public function __construct() {
        
    }
    
    /**
     * Añade un tipo de aplicación en ka configuración
     */
    public function addAppType(AppType $appType) : void {
        
    }
    
    /**
     * Borra un tipo de aplicación de la configuración
     */
    public function removeAppType(AppType $appType) : void {
        
    }
    
    /**
     * Añade una característica de aplicación a un tipo de aplicación en la configuración
     */
    public function addAppFeature(AppFeature $appFeature, AppType $appType) : void {
        
    }
    
    /**
     * Borra una característica de aplicación de un tipo de aplicación en la configuración
     */
    public function removeAppFeature(AppFeature $appFeature, AppType $appType) : void {
        
    }
    
    /**
     * Gestiona las operaciones de CRUD del administrador  
     */
    public function manageAdminRole(User $admin, $action) : void {
        
    }
    
    /**
     * Gestiona las operaciones de CRUD del comercial  
     */
    public function manageSalesRole(User $sales, $action) : void {
        
    }
    
    /**
     * Hestiona las operaciones de CRUD del jefe de proyecto  
     */
    public function manageChiefProjectRole(User $chiefProject, $action) : void {
        
    }
    
    /**
     * Gestiona las operaciones de CRUD del técnico  
     */
    public function manageTechnicianRole(User $technician, $action) : void {
        
    }
    
    /**
     * Gestiona las operaciones de CRUD del cliente  
     */
    public function manageClientRole(User $client, $action) : void {
        
    }
    
    /**
     * Gestiona las operaciones de CRUD del solicitante  
     */
    public function manageEmployeeRole(User $employee, $action) : void {
        
    }
}
