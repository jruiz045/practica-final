<?php

/**
 * Servicio que gestiona el idioma de la aplicación
 *
 */
class LanguageManager {
    
    public function __construct() {
        
    }
    
    /**
     * Traduce la página al  
     * idioma seleccionado
     *
     * Devuelve el texto traducdo al idioma correspondiente
     */
    public function translatePage(Language $language, TranslationPage $translationPage) : TranslationPage {
        
    }
    
    /**
     * Traduce el texto al  
     * idioma seleccionad'
     *
     * Devuelve el texto traducdo al idioma correspondiente
     */
    public function translateText(Language $language, TranslationText $translationText) : TranslationText {
        
    }
    
}
