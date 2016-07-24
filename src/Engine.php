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
    private function getSteps()
    {
        $i = 0;
        while ($step = array_shift($this->actions)) {
            yield $step;
            if ($i++ > 30) {
                return;
            }
        }
        return;
    }
    public function execute()
    {
        foreach ($this->getSteps() as $step) {
            $callable = $step->getCallable();
            if ($injectionParams = $step->getInjectionParams()) {
                $injectionParams->addToInjector($this->injector);
            }
            if (is_array($callable)) {
                $result = $this->injector->execute($callable[0], $callable[1]);
            } else {
                $result = $this->injector->execute($callable);
            }
            if ($result instanceof Action) {
                $this->actions[] = $result;
            }
        }
    }
}