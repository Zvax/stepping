<?php

namespace Tests;

use Auryn\Injector;

class SteppingTestCase extends \PHPUnit_Framework_TestCase
{
    protected $injector;

    public function __construct($name = null, array $data = [], $dataName = "")
    {
        /** @var Injector $injector */
        $injector = getTestInjector();
        $this->injector = $injector;
        parent::__construct($name, $data, $dataName);
    }
}