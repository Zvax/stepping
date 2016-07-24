<?php
class EngineTest extends \Tests\SteppingTestCase
{
    public function testSteps()
    {
        /** @var \Stepping\Engine $engine */
        $engine = $this->injector->make('Stepping\Engine', [
            ':next' => new Stepping\Action('Tests\Foo::bar'),
        ]);
        ob_start();
        $engine->execute();
        $string = ob_get_clean();
        $this->assertInternalType('string', $string);
        $this->assertEquals('barbaz', $string);
    }
}