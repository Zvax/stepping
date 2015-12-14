<?php

namespace Stepping;

class Step
{
    private $stepCallable;
    private $injectionParams;

    public function __construct($nextCallable, InjectionParams $injectionParams = null)
    {
        $this->stepCallable = $nextCallable;
        $this->injectionParams = $injectionParams;
    }

    public function getCallable()
    {
        return $this->stepCallable;
    }

    public function getInjectionParams()
    {
        return $this->injectionParams;
    }

}