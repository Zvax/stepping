<?php
namespace Tests;
use Auryn\Injector;
use PHPUnit\Framework\TestCase;
use Stepping\Action;
use Stepping\Engine;
class InitiationTest extends TestCase
{
    public function testInitiates()
    {
        $cb = function ()
        {
            return true;
        };
        $engine = new Engine(new Injector, new Action($cb));
        $this->assertInstanceOf('Stepping\Engine', $engine);
    }
    public function testStepCanBeRun()
    {
        $cb = function ()
        {
            return true;
        };
        $this->assertTrue(true == (new Injector)->execute(new Action($cb)));
    }
    public function testAssociateNull()
    {
        $this->assertNotTrue($injectionParams = null);
    }
}
