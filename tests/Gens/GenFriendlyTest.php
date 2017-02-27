<?php
namespace Tests\Gens;
use Auryn\Injector;
use Stepping\Action;
use Stepping\Engine;
function generate()
{
    for ($i = 0; $i !== 10; $i ++)
    {
        yield $i;
    }
}
function echoes()
{
    foreach (generate() as $value)
    {
        echo $value;
    }
}
function getEchoesTest()
{
    yield new Action('Tests\Gens\echoes');
}
function startRun()
{
    return getEchoesTest();
}
class GenFriendlyTest extends \PHPUnit_Framework_TestCase
{
    public function testGeneratorDuplication()
    {
        $engine = new Engine(new Injector, new Action('Tests\Gens\startRun'));
        ob_start();
        $engine->execute();
        $string = ob_get_clean();
        $this->assertEquals('0123456789', $string);
    }
}
