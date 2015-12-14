<?php

namespace Tests;

use Auryn\Injector;

require __DIR__."/../vendor/autoload.php";

function getTestInjector()
{
    $injector = new Injector();
    $injector->share($injector);
    return $injector;
}