<?php

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Services\EmailManager;
use Symfony\Component\Workflow\Event\Event;

class EmailSuscriber implements EventSubscriberInterface {
    
    private $emailManager;
    
    public function __construct(EmailManager $emailManager)
    {
        $this->emailManager = $emailManager;
    }
    
    public static function getSubscribedEvents()
    {
        return array('budget.requested' => 'onPresupuestoSolicitado',
                     'budget.accepted' => 'onPresupuestoAprobado',
                     'workflow.manage_project.completed' => 'onProjectStatusChanged',
                     'workflow.manage_task.completed.finished' => 'onTaskFinished');
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
    
    public function onProjectStatusChanged(Event $event) 
    {
        $project = $event->getSubjet()->getProject();
        
        $this->emailManager->enviarCorreoCambioEstadoProyectoASolicitante($project);
        $this->emailManager->enviarCorreosCambioEstadoProyectoATecnicos($project);
    }
    
    public function onTaskFinished(Event $event)
    {
        $task = $event->getSubjet()->getTask();
        $this->emailManager->enviarCorreoTareaFinalizadaAJefesProyecto($task);
    }

}
