<?php declare(strict_types=1);

namespace Stepping;

use Auryn\Injector;

/*
 * the Action is the basic operation unit of the Stepping module
 * it represents a single executable, be it a public method of a class, a function or an anonymous function
 * The Actions are executed with Auryn that resolves their dependencies
 */

class Action
{
    public function __construct(private $callable, private ?InjectionParams $injectionParams = null)
    {
        $this->injectionParams = $injectionParams ?? new InjectionParams;
    }

    public function __invoke(Injector $injector)
    {
        return $injector->execute($this->callable);
    }

    public function getInjectionParams(): InjectionParams
    {
        return $this->injectionParams;
    }
}
