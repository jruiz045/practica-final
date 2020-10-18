<?php

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Services\EmailManager;

class EmailSuscriber implements EventSubscriberInterface {
    
    private $emailManager;
    
    public function __construct(EmailManager $emailManager)
    {
        $this->emailManager = $emailManager;
    }

    
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return array('budget.requested' => 'onPresupuestoSolicitado',
                     'budget.accepted' => 'onPresupuestoAprobado');
    }
    
    public function onPresupuestoSolicitado($event)
    {
        $budgetRequest = $event->getBudgetRequest();
        $emailManager = $this->emailManager;
        
        $emailManager->enviarCorreosSolicitudPresupuestoAComerciales($budgetRequest);
        $emailManager->enviarCorreosSolicitudPresupuestoASolicitante($budgetRequest);
        
    }

    public function onPresupuestoAprobado($event)
    {
        $budgetRequest = $event->getBudgetRequest();
        $emailManager = $this->emailManager;
        
        $emailManager->enviarCorreosPresupuestoAprobadoSolicitante($budgetRequest);
        $emailManager->enviarCorreosPresupuestoAprobadoJefesProyecto($budgetRequest);
    }

}
