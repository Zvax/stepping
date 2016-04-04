<?php

namespace Zvax\Stepping;

use Auryn\Injector;

class Engine
{
    private $injector;
    private $steps = [];

    public function __construct(Injector $injector,Step $nextStep)
    {
        $this->injector = $injector;
        $this->injector->share($this->injector);
        $this->steps[] = $nextStep;
    }

    private function getSteps()
    {
        $i = 0;
        while ( $step = array_shift($this->steps) )
        {
            yield $step;
            if ($i++ > 30)
            {
                return;
            }
        }
        return;
    }


    public function execute()
    {

        foreach ($this->getSteps() as $step)
        {
            $callable = $step->getCallable();

            if ($injectionParams = $step->getInjectionParams())
            {
                $injectionParams->addToInjector($this->injector);
            }

            if (is_array($callable))
            {
                $result = $this->injector->execute($callable[0],$callable[1]);
            }
            else
            {
                $result = $this->injector->execute($callable);
            }

            if ($result instanceof  Step)
            {
                $this->steps[] = $result;
            }
        }
    }

}