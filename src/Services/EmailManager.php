<?php

/**
 * Servicio que gestiona el envío de correo
 *
 */
class EmailManager {

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
    public function enviarCorreosPresupuestoAprobado(SolicitudPresupuesto $solicitud): boolean {
        
    }

}
