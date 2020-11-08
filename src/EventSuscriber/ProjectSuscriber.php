<?php

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\GuardEvent;

class ProjectSuscriber implements EventSubscriberInterface {
    
    public static function getSubscribedEvents()
    {
        return array('workflow.manage_project.to_finished' => array('checkCompletedTasks'));
    }
    
    public function checkCompletedTasks(GuardEvent $event)
    {
        $project = $event->getSubject();
        $task_list = $project->getTasks();
        foreach($task_list as $task) {
            if($task->getState() != 'finished') {
                $event->setBlocked(true, 'No ha podido realizarse la acción porque quedan tareas por terminar');
                break;
            }
        }
    }
}
