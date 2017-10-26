<?php
declare(strict_types=1);

namespace Stepping;

use Auryn\Injector;
class Action
{
    private $callable;
    private $injectionParams;
    public function __construct(
        $callable,
        InjectionParams $injectionParams = null
    ) {
        $this->callable = $callable;
        $this->injectionParams = $injectionParams;
    }
    function __invoke(Injector $injector)
    {
        return $injector->execute($this->callable);
    }
    /**
     * @return InjectionParams
     */
    public function getInjectionParams()
    {
        return $this->injectionParams;
    }
}
