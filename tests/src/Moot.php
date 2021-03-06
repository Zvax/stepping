<?php
declare(strict_types=1);

namespace Tests;

class Moot
{
    private $stringArg;

    public function __construct($stringArg)
    {
        $this->stringArg = $stringArg;
    }

    public function getStringArg()
    {
        return $this->stringArg;
    }
}
