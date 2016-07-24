<?php

class EngineTest extends \Tests\SteppingTestCase
{
    public function testSteps()
    {

        /** @var \Stepping\Engine $engine */
        $engine = $this->injector->make("\\Stepping\\Engine",[
            ":nextStep" => new Stepping\Step("Tests\\Foo::bar"),
        ]);
        $this->assertInstanceOf("\\Stepping\\Engine",$engine);

        ob_start();
        $engine->execute();
        $string = ob_get_clean();

        $this->assertInternalType('string',$string);
        $this->assertEquals('barbaz',$string);
    }
}