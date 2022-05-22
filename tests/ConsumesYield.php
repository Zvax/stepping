<?php declare(strict_types=1);

namespace Stepping\Tests;

use Stepping\Action;

class ConsumesYield
{
    public function generator(): \Generator
    {
        $product = yield new Action('Stepping\Tests\mirrorYieldReturn');
        echo $product;
    }
}
