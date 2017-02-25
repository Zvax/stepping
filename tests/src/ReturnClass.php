<?php
namespace Tests;
use Stepping\Action;
class ReturnClass {
    public function getValue()
    {
        return 'value';
    }
    public function shouldReceiveFromYield()
    {
        $valueFromItself = yield new Action('Tests\ReturnClass::getValue');
        echo $valueFromItself;
    }
}
