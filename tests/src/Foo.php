<?php

namespace Tests;

use Zvax\Stepping\Step;

class Foo
{
    public function bar()
    {
        echo 'bar';
        return new Step("Tests\\Bar::baz");
    }
}