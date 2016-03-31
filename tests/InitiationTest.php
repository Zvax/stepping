<?php

class InitiationTest extends \Tests\SteppingTestCase
{

    public function testInitiates()
    {
        $step = new Zvax\Stepping\Step(function() {return true;});
        $engine = new Zvax\Stepping\Engine($this->injector,$step);
        $this->assertInstanceOf("\\Zvax\\Stepping\\Engine",$engine);
    }

    public function testStepCanBeRun()
    {
        /** @var \Zvax\Stepping\Step $step */
        $step = new Zvax\Stepping\Step(function() {return true;});
        $this->assertTrue(true == $this->injector->execute($step->getCallable()));
    }

    public function testAssociateNull()
    {
        $this->assertNotTrue($injectionParams = null);
    }

}