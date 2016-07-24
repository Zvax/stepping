<?php
class InitiationTest extends \Tests\SteppingTestCase
{
    public function testInitiates()
    {
        $action = new Stepping\Action(function () {
            return true;
        });
        $engine = new Stepping\Engine($this->injector, $action);
        $this->assertInstanceOf("\\Stepping\\Engine", $engine);
    }
    public function testStepCanBeRun()
    {
        /** @var \Stepping\Action $action */
        $action = new Stepping\Action(function () {
            return true;
        });
        $this->assertTrue(true == $this->injector->execute($action));
    }
    public function testAssociateNull()
    {
        $this->assertNotTrue($injectionParams = null);
    }
}