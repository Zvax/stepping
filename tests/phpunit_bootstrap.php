<?php

namespace Tests;

use Auryn\Injector;

require __DIR__."/../vendor/autoload.php";

function getTestInjector()
{
    return new Injector();
}