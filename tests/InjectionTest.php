<?php declare(strict_types=1);

namespace Stepping\Tests;

use Auryn\Injector;
use PHPUnit\Framework\TestCase;
use Stepping\Action;
use Stepping\Engine;
use Stepping\InjectionParams;

class InjectionTest extends TestCase
{
    public function testPrepare(): void
    {
        $prep = static function ($obj) {
            $obj->foo = 42;
        };
        $injector = new Injector;
        $params = new InjectionParams([], [], [], [], [], [
            Bar::class => $prep,
        ]);
        $params->addToInjector($injector);
        $bar = $injector->make(Bar::class);
        $this->assertInstanceOf(Bar::class, $bar);
        $this->assertEquals(42, $bar->foo);
    }

    public function testSendingParamsWithAction(): void
    {
        $injector = new Injector;
        $next = new Action(ReturnClass::class . '::wantsAndEchoesScalarParam', new InjectionParams([], [], [], [
            'param' => 'value',
        ]));
        $engine = new Engine($injector, $next);
        ob_start();
        $engine->execute();
        $string = ob_get_clean();
        $this->assertEquals('value', $string);
    }

    public function testParams(): void
    {
        $func = function ($param) {
            return $param;
        };
        $injector = new Injector;
        $injection = new InjectionParams([], [], [], [
            'param' => 'value',
        ]);
        $injection->addToInjector($injector);
        $this->assertEquals('value', $injector->execute($func));
    }
}
