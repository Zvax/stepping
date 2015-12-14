<?php

class InitiationTest extends \Tests\SteppingTestCase
{

    public function testInitiates()
    {
        $injector = \Tests\getTestInjector();
        $step = new \Stepping\Step(function() {return true;});
        $engine = new \Stepping\Engine($injector,$step);
        $this->assertInstanceOf("Stepping\\Engine",$engine);
    }

    public function testStepCanBeRun()
    {
        /** @var \Stepping\Step $step */
        $step = new \Stepping\Step(function() {return true;});
        $injector = \Tests\getTestInjector();
        $this->assertTrue(true == $injector->execute($step->getCallable()));
    }

    public function testAssociateNull()
    {
        $this->assertNotTrue($injectionParams = null);
    }

}