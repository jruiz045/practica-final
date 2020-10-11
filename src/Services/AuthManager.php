<?php

/**
 * Servicio que gestiona la identificación de usuarios
 *
 */
class AuthManager {
    
    
    public function __construct() {
        
    }
    
    /**
     * Identifica a un usuario 
     * para inicial sesión
     *
     * Devuelve true si los datos son correctos o false si 
     * no lo son
     */
    public function login(User $user): boolean {
        
    }
    
    /**
     * Desconecta a un usuario 
     * de su sesión
     */
    public function logout(User $user) {
        
    }
}
