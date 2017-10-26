<?php
declare(strict_types=1);

namespace Tests;

use Auryn\Injector;
use Stepping\Action;
use Stepping\Engine;
class InitiationTest extends \PHPUnit_Framework_TestCase
{
    public function testInitiates()
    {
        $cb = function () {
            return true;
        };
        $engine = new Engine(new Injector, new Action($cb));
        $this->assertInstanceOf('Stepping\Engine', $engine);
    }
    public function testStepCanBeRun()
    {
        $cb = function () {
            return true;
        };
        $this->assertTrue(true == (new Injector)->execute(new Action($cb)));
    }
    public function testAssociateNull()
    {
        $this->assertNotTrue($injectionParams = null);
    }
}
