<?php
namespace Tests;
use Auryn\Injector;
use Stepping\InjectionParams;
class StepTest extends \PHPUnit_Framework_TestCase
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
