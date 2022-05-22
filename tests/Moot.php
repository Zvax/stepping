<?php declare(strict_types=1);

namespace Stepping\Tests;

class Moot
{
    public function __construct(private string $stringArg)
    {
    }

    public function getStringArg(): string
    {
        return $this->stringArg;
    }
}
