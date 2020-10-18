<?php

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Services\EmailManager;

class EmailSuscriber implements EventSubscriberInterface {
    
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return array('budget.requested' => 'onPresupuestoSolicitado',
                     'budget.accepted' => 'onPresupuestoAprobado');
    }
    
    public function onPresupuestoSolicitado($event, EmailManager $emailManager)
    {
        $budgetRequest = $event->getBudgetRequest();
        $emailManager->enviarCorreosSolicitudPresupuestoAComerciales($budgetRequest);
        $emailManager->enviarCorreosSolicitudPresupuestoASolicitante($budgetRequest);
        
    }

    public function onPresupuestoAprobado($event, EmailManager $emailManager)
    {
        $budgetRequest = $event->getBudgetRequest();
        $emailManager->enviarCorreosPresupuestoAprobado($budgetRequest);
    }

}
