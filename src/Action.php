<?php
namespace Stepping;
class Action
{
    private $callable;
    private $next;
    private $injectionParams;
    public function __construct(
        $callable,
        $next = null,
        InjectionParams $injectionParams = null
    )
    {
        $this->callable = $callable;
        $this->next = $next;
        $this->injectionParams = $injectionParams;
    }
    /**
     * @return mixed
     */
    public function getCallable()
    {
        return $this->callable;
    }
    /**
     * @return null
     */
    public function getNext()
    {
        return $this->next;
    }
    /**
     * @return InjectionParams
     */
    public function getInjectionParams()
    {
        return $this->injectionParams;
    }

}