<?php

namespace Tests;

class SteppingTestCase extends \PHPUnit_Framework_TestCase
{
    protected $injector;

    public function __construct($name = null, array $data = [], $dataName = "")
    {
        $this->injector = getTestInjector();
        parent::__construct($name, $data, $dataName);
    }
}