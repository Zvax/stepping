<?php

class EngineTest extends \Tests\SteppingTestCase
{
    public function testSteps()
    {

        /** @var \Zvax\Stepping\Engine $engine */
        $engine = $this->injector->make("\\Zvax\\Stepping\\Engine",[
            ":nextStep" => new \Zvax\Stepping\Step("Tests\\Foo::bar"),
        ]);
        $this->assertInstanceOf("\\Zvax\\Stepping\\Engine",$engine);

        ob_start();
        $engine->execute();
        $string = ob_get_clean();

        $this->assertInternalType('string',$string);
        $this->assertEquals('barbaz',$string);
    }
}