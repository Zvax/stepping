<?php

namespace Tests;

use Auryn\Injector;
use Zvax\Stepping\InjectionParams;

class InjectionTest extends SteppingTestCase
{

    public function testPrepare()
    {
        $prep = function($obj, $injector)
        {
            $obj->foo = 42;
        };
        $injector = new Injector();

        $params = new InjectionParams([],[],[],[],[],[
            'Tests\Bar' => $prep,
        ]);
        $params->addToInjector($injector);

        $bar = $injector->make('Tests\Bar');

        $this->assertInstanceOf('Tests\Bar', $bar);
        $this->assertEquals(42, $bar->foo);
    }

}