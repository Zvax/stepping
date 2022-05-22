<?php declare(strict_types=1);

namespace Stepping\Tests;

use Stepping\Action;

function generate(): \Generator
{
    for ($i = 0; $i !== 10; $i++) {
        yield $i;
    }
}

function echoes(): void
{
    foreach (generate() as $value) {
        echo $value;
    }
}

function startRun(): \Generator
{
    return getEchoesTest();
}

function getEchoesTest(): \Generator
{
    yield new Action('Stepping\Tests\echoes');
}

function mirrorYieldReturn(): string
{
    return 'generated product';
}

function echoes_small_string(): void
{
    echo "01234";
}
