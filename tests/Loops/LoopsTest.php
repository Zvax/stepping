<?php
namespace Tests\Loops;
use Auryn\Injector;
use Stepping\Action;
use Stepping\Engine;
function loopSteps()
{
    for ($i = 0; $i !== 5; $i++)
    {
        echo $i;
    }
}
class LoopsTest extends \PHPUnit_Framework_TestCase
{
    public function testStepHappensOnlyOnce()
    {
        $engine = new Engine(
            new Injector,
            new Action('Tests\Loops\loopSteps')
        );
        ob_start();
        $engine->execute();
        $string = ob_get_clean();
        $this->assertEquals('01234', $string);
    }
    public function testCanSendCallableToAction()
    {

        $engine = new Engine(
            new Injector,
            new Action('Tests\Loops\loopSteps')
        );
        ob_start();
        $engine->execute();
        $string = ob_get_clean();
        $this->assertEquals('01234', $string);
    }
}
