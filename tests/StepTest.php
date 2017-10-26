<?php
declare(strict_types=1);

namespace Tests;

use Auryn\Injector;
use PHPUnit\Framework\TestCase;
use Stepping\Action;
use Stepping\InjectionParams;
class StepTest extends TestCase
{
    public function testDependenciesAreConstructed()
    {
        $injector = new Injector;
        $injectionParams = new InjectionParams([], [], [], [
            "stringArg" => "stringValue"
        ]);
        $this->assertInstanceOf("\\Stepping\\InjectionParams", $injectionParams);
        $injectionParams->addToInjector($injector);

        $moot = $injector->make("\\Tests\\Moot");
        $this->assertInstanceOf("Tests\\Moot", $moot);

        $this->assertEquals("stringValue", $moot->getStringArg());
    }
    public function testReturnsAndYields()
    {
        $action = function () {
            yield 1;
            $received = (yield 2);
            yield $received;
            yield new Action(function () {
                echo 'ok';
            });
        };
        /** @var \Generator $gen */
        $gen = $action();
        $this->assertEquals(1, $gen->current());
        $gen->next();
        $this->assertEquals(2, $gen->current());
        $gen->send(3);
        $this->assertEquals(3, $gen->current());
        $gen->next();
        $this->assertInstanceOf('Stepping\Action', $gen->current());
    }
    public function testYieldsArrayValues()
    {
        function gen()
        {
            yield 1;
            yield 2 => 3;
        }

        $gen = gen();
        $this->assertEquals(1, $gen->current());
        $gen->next();
        $this->assertEquals(2, $gen->key());
        $this->assertEquals(3, $gen->current());
    }
}
