<?php declare(strict_types=1);

namespace Stepping\Tests;

use Stepping\Action;

class Foo
{
    public function bar(): Action
    {
        echo 'bar';
        return new Action(Bar::class . '::baz');
    }
}
