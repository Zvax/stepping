<?php
namespace Stepping;
use Auryn\Injector;
class Engine
{
    private $injector;
    private $actions = [];
    public function __construct(Injector $injector, Action $next)
    {
        $this->injector = $injector;
        $this->injector->share($this->injector);
        $this->actions[] = $next;
    }
    private function getActions()
    {
        $i = 0;
        while ($action = array_shift($this->actions)) {
            yield $action;
            if ($i++ > 30) {
                return;
            }
        }
        return;
    }
    private function dispatchAction(Action $action)
    {
        if ($injectionParams = $action->getInjectionParams()) {
            $injectionParams->addToInjector($this->injector);
        }
        $result = $this->injector->execute($action);
        if ($next = $action->getNext())
        {
            $this->dispatchAction($action);
        }
        if ($result instanceof Action) {
            $this->actions[] = $result;
        }
    }
    public function execute()
    {
        /** @var Action $action */
        foreach ($this->getActions() as $action) {
            $this->dispatchAction($action);
        }
    }
}