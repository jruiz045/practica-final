<?php

/**
 * Servicio que gestiona la el panel de administración
 *
 */

class AdminPanelManager {
    public function __construct() {
        
    }
    
    /**
     * Añade un tipo de aplicación  
     */
    public function addAppType(AppType $appType) : void {
        
    }
    
    /**
     * Borra un tipo de aplicación  
     */
    public function removeAppType(AppType $appType) : void {
        
    }
    
    /**
     * Añade una característica de aplicación a un tipo de aplicación  
     */
    public function addAppFeature(AppFeature $appFeature, AppType $appType) : void {
        
    }
    
    /**
     * Borra una característica de aplicación de un tipo de aplicación  
     */
    public function removeAppFeature(AppFeature $appFeature, AppType $appType) : void {
        
    }
    
    /**
     * Centraliza las operaciones de CRUD del administrador  
     */
    public function manageAdminRole(User $user, $action) {
        
    }
    
    /**
     * Centraliza las operaciones de CRUD del comercial  
     */
    public function manageSalesRole(User $user, $action) {
        
    }
    
    /**
     * Centraliza las operaciones de CRUD del jefe de proyecto  
     */
    public function manageChiefProjectRole(User $user, $action) {
        
    }
    
    /**
     * Centraliza las operaciones de CRUD del técnico  
     */
    public function manageTechnicianRole(User $user, $action) {
        
    }
    
    /**
     * Centraliza las operaciones de CRUD del cliente  
     */
    public function manageClientRole(User $user, $action) {
        
    }
    
    /**
     * Centraliza las operaciones de CRUD del solicitante  
     */
    public function manageEmployeeRole(User $user, $action) {
        
    }
}
