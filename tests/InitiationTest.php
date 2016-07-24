<?php

class InitiationTest extends \Tests\SteppingTestCase
{

    public function testInitiates()
    {
        $step = new Stepping\Action(function() {return true;});
        $engine = new Stepping\Engine($this->injector,$step);
        $this->assertInstanceOf("\\Stepping\\Engine",$engine);
    }

    public function testStepCanBeRun()
    {
        /** @var \Stepping\Action $step */
        $step = new Stepping\Action(function() {return true;});
        $this->assertTrue(true == $this->injector->execute($step->getCallable()));
    }

    public function testAssociateNull()
    {
        $this->assertNotTrue($injectionParams = null);
    }

}