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
        return array('budget.requested' => 'onPresupuestoSolicitado',
                     'budget.accepted' => 'onPresupuestoAprobado');
    }
    
    public function onPresupuestoSolicitado(BudgetRequestedEvent $event)
    {
        $budgetRequest = $event->getBudgetRequest();
        
        $this->emailManager->enviarCorreosSolicitudPresupuestoAComerciales($budgetRequest);
        $this->emailManager->enviarCorreosSolicitudPresupuestoASolicitante($budgetRequest);
        
    }

    public function onPresupuestoAprobado(BudgetAccptedEvent $event)
    {
        $budgetRequest = $event->getBudgetRequest();
        
        $this->emailManager->enviarCorreosPresupuestoAprobadoSolicitante($budgetRequest);
        $this->emailManager->enviarCorreosPresupuestoAprobadoJefesProyecto($budgetRequest);
    }

}
