<?php declare(strict_types=1);

namespace Stepping\Tests;

use Auryn\Injector;
use PHPUnit\Framework\TestCase;
use Stepping\Action;
use Stepping\Engine;

class InitiationTest extends TestCase
{
    public function testInitiates(): void
    {
        $cb = function () {
            return true;
        };
        $engine = new Engine(new Injector, new Action($cb));
        $this->assertInstanceOf('Stepping\Engine', $engine);
    }

    public function testStepCanBeRun(): void
    {
        $cb = function () {
            return true;
        };
        $this->assertTrue(true == (new Injector)->execute(new Action($cb)));
    }

    public function testAssociateNull(): void
    {
        $this->assertNotTrue($injectionParams = null);
    }
}
