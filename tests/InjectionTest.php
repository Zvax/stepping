<?php
declare(strict_types=1);

namespace Tests;

use Auryn\Injector;
use PHPUnit\Framework\TestCase;
use Stepping\Action;
use Stepping\Engine;
use Stepping\InjectionParams;
class InjectionTest extends TestCase
{
    public function testPrepare()
    {
        $prep = function ($obj, $injector) {
            $obj->foo = 42;
        };
        $injector = new Injector;
        $params = new InjectionParams([], [], [], [], [], [
                'Tests\Bar' => $prep,
            ]);
        $params->addToInjector($injector);
        $bar = $injector->make('Tests\Bar');
        $this->assertInstanceOf('Tests\Bar', $bar);
        $this->assertEquals(42, $bar->foo);
    }
    public function testSendingParamsWithAction()
    {
        $injector = new Injector;
        $next = new Action('Tests\ReturnClass::wantsAndEchoesScalarParam', new InjectionParams([], [], [], [
                'param' => 'value',
            ]));
        $engine = new Engine($injector, $next);
        ob_start();
        $engine->execute();
        $string = ob_get_clean();
        $this->assertEquals('value', $string);
    }
    public function testParams()
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
