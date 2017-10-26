<?php
declare(strict_types=1);

namespace Tests;

use Stepping\Action;
class Foo
{
    public function bar()
    {
        echo 'bar';
        return new Action('Tests\Bar::baz');
    }
}
