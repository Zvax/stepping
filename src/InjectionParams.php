<?php

namespace Stepping;

use Auryn\Injector;

class InjectionParams
{
    private $shares = [];
    private $aliases = [];
    private $definitions = [];
    private $params = [];

    public function __construct($shares = [],$aliases = [],$definitions = [],$params = [])
    {
        $this->shares = $shares;
        $this->aliases = $aliases;
        $this->definitions = $definitions;
        $this->params = $params;
    }

    public function addToInjector(Injector $injector)
    {
        foreach ($this->shares as $share)
        {
            $injector->share($share);
        }
        foreach ($this->aliases as $original => $alias)
        {
            $injector->alias($original, $alias);
        }
        foreach ($this->definitions as $name => $args)
        {
            $injector->define($name,$args);
        }
        foreach ($this->params as $param => $value)
        {
            $injector->defineParam($param,$value);
        }
    }

}