<?php

class InitiationTest extends \Tests\SteppingTestCase
{

    public function testInitiates()
    {
        $step = new \Stepping\Step(function() {return true;});
        $engine = new \Stepping\Engine($this->injector,$step);
        $this->assertInstanceOf("Stepping\\Engine",$engine);
    }

    public function testStepCanBeRun()
    {
        /** @var \Stepping\Step $step */
        $step = new \Stepping\Step(function() {return true;});
        $this->assertTrue(true == $this->injector->execute($step->getCallable()));
    }

    public function testAssociateNull()
    {
        $this->assertNotTrue($injectionParams = null);
    }

}