<?php
use Symfony\Contracts\EventDispatcher\Event;

class BudgetRequestedEvent extends Event {
    private $budget;
            
    function __construct($budget) {
        $this->budget = $budget;
    }
    function getBudget() {
        return $this->budget;
    }
}
