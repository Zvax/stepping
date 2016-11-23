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
}
