<?php
namespace Stepping;
use Auryn\Injector;
class Action
{
    private $callable;
    private $next;
    private $injectionParams;
    public function __construct(
        $callable,
        Action $next = null,
        InjectionParams $injectionParams = null
    )
    {
        $this->callable = $callable;
        $this->next = $next;
        $this->injectionParams = $injectionParams;
    }
    function __invoke(Injector $injector)
    {
        return $injector->execute($this->callable);
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