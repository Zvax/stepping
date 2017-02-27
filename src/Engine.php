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
    private function loopGenerator(\Generator $product)
    {
        $current = null;
        while ($product->valid())
        {
            $current = $product->current();
            $subProduct = null;
            if ($current instanceof Action)
            {
                $subProduct = $this->dispatchAction($current);
                /*
                if ($injectionParams = $current->getInjectionParams())
                {
                    $injectionParams->addToInjector($this->injector);
                }
                $subProduct = $this->injector->execute($current);
                */
            }
            else if (is_callable($current))
            {
                $subProduct = $this->injector->execute($current);
            }
            $product->send($subProduct);
        }
        return $current;
    }
    private function dispatchAction(Action $action)
    {
        if ($injectionParams = $action->getInjectionParams()) {
            $injectionParams->addToInjector($this->injector);
        }
        $product = $this->injector->execute($action);
        if ($product instanceof \Generator)
        {
            while ($product instanceof \Generator)
            {
                $product = $this->loopGenerator($product);
            }
        }
        return $product;
    }
    public function execute()
    {
        /** @var Action $action */
        foreach ($this->getActions() as $action) {
            $product = $this->dispatchAction($action);
            if ($product instanceof Action) {
                $this->actions[] = $product;
            }
        }
    }
}
