<?php

class StepTest extends \Tests\SteppingTestCase
{
    public function testDependenciesAreConstructed()
    {
        $injectionParams = new Stepping\InjectionParams([],[],[],[
            "stringArg" => "stringValue"
        ]);
        $this->assertInstanceOf("\\Stepping\\InjectionParams",$injectionParams);
        $injectionParams->addToInjector($this->injector);

        $moot = $this->injector->make("\\Tests\\Moot");
        $this->assertInstanceOf("Tests\\Moot",$moot);

        $this->assertEquals("stringValue", $moot->getStringArg());
    }
}