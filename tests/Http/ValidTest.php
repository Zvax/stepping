<?php
namespace Tests\Http;
use Auryn\Injector;
use Stepping\Action;
use Stepping\Engine;
function send()
{
    header('content-type', 'text/plain');
    echo 'content';
}
function buildResponse() {
    return new Action('Tests\Http\send');
}
class ValidTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @runInSeparateProcess
     * because otherwise problems happen with headers already sent
     */
    public function testUniqueHeaders()
    {
        ob_start();
        $action = new Action('Tests\Http\buildResponse');
        $engine = new Engine(new Injector, $action);
        $engine->execute();
        $string = ob_get_clean();
        $this->assertEquals('content', $string);
    }
}
