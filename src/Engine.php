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
    private function loopGenerator(\Generator $generator)
    {
        $current = null;
        while ($generator->valid())
        {
            $current = $generator->current();
            if (
                is_callable($current)
                || $current instanceof Action
                || $current instanceof \Generator
            )
            {
                $stepResult = $this->dispatch($current);
                $generator->send($stepResult);
            }
            else
            {
                $generator->next();
            }
        }
        return $generator->current();
    }
    private function dispatch($action)
    {
        if ($action instanceof Action)
        {
            if ($injectionParams = $action->getInjectionParams()) {
                $injectionParams->addToInjector($this->injector);
            }
            return $this->injector->execute($action);
        }
        else if ($action instanceof \Generator)
        {
            return $this->loopGenerator($action);
        }
        else if (is_callable($action))
        {
            return $this->injector->execute($action);
        }
        return false;
    }
    public function execute()
    {
        foreach ($this->getActions() as $action)
        {
            $result = $this->dispatch($action);
            if (
                is_callable($result)
                || $result instanceof Action
                || $result instanceof \Generator
            )
            {
                $this->actions[] = $result;
            }
        }
    }
}
