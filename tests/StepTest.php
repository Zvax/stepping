<?php

class StepTest extends \Tests\SteppingTestCase
{
    public function testDependenciesAreConstructed()
    {
        $injectionParams = new \Zvax\Stepping\InjectionParams([],[],[],[
            "stringArg" => "stringValue"
        ]);
        $this->assertInstanceOf("\\Zvax\\Stepping\\InjectionParams",$injectionParams);
        $injectionParams->addToInjector($this->injector);

        $moot = $this->injector->make("\\Tests\\Moot");
        $this->assertInstanceOf("Tests\\Moot",$moot);

        $this->assertEquals("stringValue", $moot->getStringArg());
    }
}