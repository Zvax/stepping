<?php
declare(strict_types=1);

namespace Stepping;

use Auryn\Injector;
class InjectionParams
{
    private $shares = [];
    private $aliases = [];
    private $definitions = [];
    private $params = [];
    private $delegates = [];
    private $prepares = [];
    public function __construct(
        $shares = [],
        $aliases = [],
        $definitions = [],
        $params = [],
        $delegates = [],
        $prepares = []
    ) {
        $this->shares = $shares;
        $this->aliases = $aliases;
        $this->definitions = $definitions;
        $this->params = $params;
        $this->delegates = $delegates;
        $this->prepares = $prepares;
    }
    public static function fromRouteParams($params)
    {
        $return = [];
        foreach ($params as $key => $value) {
            $return[$key] = $value;
        }
        return new self([], [], [], $return);
    }
    public function addToInjector(Injector $injector)
    {
        foreach ($this->shares as $share) {
            $injector->share($share);
        }
        foreach ($this->aliases as $original => $alias) {
            $injector->alias($original, $alias);
        }
        foreach ($this->definitions as $name => $args) {
            $injector->define($name, $args);
        }
        foreach ($this->params as $param => $value) {
            $injector->defineParam($param, $value);
        }
        foreach ($this->delegates as $param => $callable) {
            $injector->delegate($param, $callable);
        }
        foreach ($this->prepares as $class => $callable) {
            $injector->prepare($class, $callable);
        }
    }
}
