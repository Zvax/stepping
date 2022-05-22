<?php declare(strict_types=1);

namespace Stepping\Tests;

use Auryn\Injector;
use PHPUnit\Framework\TestCase;
use Stepping\Action;
use Stepping\Engine;

class EngineTest extends TestCase
{
    public function testSteps(): void
    {
        $injector = new Injector;
        $next = new Action(Foo::class . '::bar');
        $engine = new Engine($injector, $next);
        ob_start();
        $engine->execute();
        $string = ob_get_clean();
        $this->assertIsString($string);
        $this->assertEquals('barbaz', $string);
    }

    public function testCanReceiveFromYieldAndReturnNewCallable(): void
    {
        $injector = new Injector;
        $next = new Action(ReturnClass::class . '::shouldReceiveFromYieldsCallable');
        $engine = new Engine($injector, $next);
        ob_start();
        $engine->execute();
        $string = ob_get_clean();
        $this->assertEquals('valueFromInjectorActivatedFunction', $string);
    }

    public function testSubActionCanSendParams(): void
    {
        $injector = new Injector;
        $next = new Action(ReturnClass::class . '::shouldReceivedSentParamFromYield');
        $engine = new Engine($injector, $next);
        ob_start();
        $engine->execute();
        $string = ob_get_clean();
        $this->assertEquals('value', $string);
    }

    public function testActionInExternalClassGetsSentValue(): void
    {
        $injector = new Injector;
        $next = new Action(ReturnClass::class . '::shouldReceiveFromYield');
        $engine = new Engine($injector, $next);
        ob_start();
        $engine->execute();
        $string = ob_get_clean();
        $this->assertEquals('valueFromClass', $string);
    }

    public function testActionCanReceiveFromStringExecutable(): void
    {
        $injector = new Injector;
        $next = new Action(function () {
            $subValue = (yield new Action(ReturnClass::class . '::getValue'));
            $subValue2 = (yield new Action('Stepping\Tests\getValue'));
            echo "$subValue$subValue2";
        });
        $engine = new Engine($injector, $next);
        ob_start();
        $engine->execute();
        $string = ob_get_clean();
        $this->assertEquals('valueFromClassvalueFromInjectorActivatedFunction', $string);
    }

    public function testActionCanReceive(): void
    {
        $injector = new Injector;
        $action = new Action(function () {
            $value = (yield new Action(function () {
                return 'promised';
            }));
            echo $value;
        });
        $engine = new Engine($injector, $action);
        ob_start();
        $engine->execute();
        $str = ob_get_clean();
        $this->assertEquals('promised', $str);
    }

    public function testLoopAndSendValues(): void
    {
        function makeGen()
        {
            for ($i = 1; $i < 6; $i++) {
                $value = (yield $i);
                echo $value;
            }
        }

        $gen = makeGen();
        ob_start();
        $i = 0;
        echo $gen->current();
        while ($fromGenerator = $gen->send(++$i)) {
            echo $fromGenerator;
        }
        $str = ob_get_clean();
        $this->assertEquals('1122334455', $str);
    }

    public function testYieldedFunctionIsExecuted(): void
    {
        $injector = new Injector;
        $next = new Action(ReturnClass::class . '::shouldYieldExecutedFunction');
        $engine = new Engine($injector, $next);
        ob_start();
        $engine->execute();
        $string = ob_get_clean();
        $this->assertEquals('okokfrom yield new action', $string);
    }

    /** @test */
    public function action_echoes_small_string(): void
    {
        $engine = new Engine(new Injector, new Action('Stepping\Tests\echoes_small_string'));
        ob_start();
        $engine->execute();
        $string = ob_get_clean();
        $this->assertEquals('01234', $string);
    }
}
