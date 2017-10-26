<?php
declare(strict_types=1);

namespace Stepping;

use Auryn\Injector;

/*
 * The engine takes care of looping over the actions until there are none left
 *
 * it expects to be built with the first action of the application
 * and will keep executing actions as long as they return other actions or generators
 *
 */

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
    private function getActions(): \Generator
    {
        $i = 0;
        while ($action = array_shift($this->actions)) {
            yield $action;
            // arbitrary limit of the number of actions an application can generate
            // I believe I made that as a infinite loop guard, it seems pretty strange now
            if (++$i > 30) {
                return;
            }
        }
        return;
    }
    /*
     * this routine is tasked with looping over the results of a generator when an action returns one
     * technically the goal would be to feed the last generator step to the next one
     *
     * for instance, used like
     * $foos = yield new Action(Mapper\Foo::class . '::fetchFoos');
     *
     */
    private function loopGenerator(\Generator $generator)
    {
        $current = null;
        while ($generator->valid()) {
            $current = $generator->current();
            if (is_callable($current) || $current instanceof Action || $current instanceof \Generator) {
                $stepResult = $this->dispatch($current);
                $generator->send($stepResult);
            } else {
                $generator->next();
            }
        }
        return $generator->current();
    }
    private function dispatch($action)
    {
        if ($action instanceof Action) {
            if ($injectionParams = $action->getInjectionParams()) {
                $injectionParams->addToInjector($this->injector);
            }
            return $this->injector->execute($action);
        } else {
            if ($action instanceof \Generator) {
                return $this->loopGenerator($action);
            } else {
                if (is_callable($action)) {
                    return $this->injector->execute($action);
                }
            }
        }
        return false;
    }
    public function execute(): void
    {
        foreach ($this->getActions() as $action) {
            $result = $this->dispatch($action);
            if (is_callable($result) || $result instanceof Action || $result instanceof \Generator) {
                $this->actions[] = $result;
            }
        }
    }
}
