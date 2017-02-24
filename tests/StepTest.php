<?php
namespace Tests;
use Auryn\Injector;
use PHPUnit\Framework\TestCase;
use Stepping\InjectionParams;
class StepTest extends TestCase
{
    public function testDependenciesAreConstructed()
    {
        $injector = new Injector;
        $injectionParams = new InjectionParams([],[],[],[
            "stringArg" => "stringValue"
        ]);
        $this->assertInstanceOf("\\Stepping\\InjectionParams",$injectionParams);
        $injectionParams->addToInjector($injector);

        $moot = $injector->make("\\Tests\\Moot");
        $this->assertInstanceOf("Tests\\Moot",$moot);

        $this->assertEquals("stringValue", $moot->getStringArg());
    }
}
