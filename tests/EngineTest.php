<?php
namespace Tests;
use Auryn\Injector;
use Stepping\Action;
use Stepping\Engine;
class EngineTest extends \PHPUnit_Framework_TestCase
{
    public function testSteps()
    {
        $injector = new Injector;
        $next = new Action('Tests\Foo::bar');
        $engine = new Engine($injector, $next);
        ob_start();
        $engine->execute();
        $string = ob_get_clean();
        $this->assertInternalType('string', $string);
        $this->assertEquals('barbaz', $string);
    }
    public function testActionInExternalClassGetsSentValue()
    {
        $injector = new Injector;
        $next = new Action('Tests\ReturnClass::shouldReceiveFromYield');
        $engine = new Engine($injector, $next);
        ob_start();
        $engine->execute();
        $string = ob_get_clean();
        $this->assertEquals('value', $string);
    }
    public function testActionCanReceiveFromStringExecutable()
    {
        $injector = new Injector;
        $next = new Action(function()
        {
            $subValue = (yield new Action('Tests\ReturnClass::getValue'));
            echo $subValue;
        });
        $engine = new Engine($injector, $next);
        ob_start();
        $engine->execute();
        $string = ob_get_clean();
        $this->assertEquals('value', $string);
    }
    public function testActionCanReceive()
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
    public function testLoopAndSendValues()
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
}
