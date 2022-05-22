<?php declare(strict_types=1);

namespace Stepping\Tests;

use Auryn\Injector;
use PHPUnit\Framework\TestCase;
use Stepping\Action;
use Stepping\InjectionParams;

class StepTest extends TestCase
{
    public function testDependenciesAreConstructed(): void
    {
        $injector = new Injector;
        $injectionParams = new InjectionParams([], [], [], [
            "stringArg" => "stringValue"
        ]);
        $this->assertInstanceOf(InjectionParams::class, $injectionParams);
        $injectionParams->addToInjector($injector);

        $moot = $injector->make(Moot::class);
        $this->assertInstanceOf(Moot::class, $moot);

        $this->assertEquals("stringValue", $moot->getStringArg());
    }

    public function testReturnsAndYields(): void
    {
        $action = function () {
            yield 1;
            $received = (yield 2);
            yield $received;
            yield new Action(function () {
                echo 'ok';
            });
        };

        $gen = $action();
        $this->assertEquals(1, $gen->current());
        $gen->next();
        $this->assertEquals(2, $gen->current());
        $gen->send(3);
        $this->assertEquals(3, $gen->current());
        $gen->next();
        $this->assertInstanceOf(Action::class, $gen->current());
    }

    public function testYieldsArrayValues(): void
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
