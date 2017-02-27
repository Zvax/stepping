<?php
namespace Tests;
use Stepping\Action;
use Stepping\InjectionParams;
class ReturnClass {
    public function getValue()
    {
        return 'value';
    }
    public function shouldReceiveFromYield()
    {
        $valueFromItself = (yield new Action('Tests\ReturnClass::getValue'));
        echo $valueFromItself;
    }
    public function shouldReceivedSentParamFromYield()
    {
        $valueFromItself = (yield new Action(
            'Tests\ReturnClass::wantsAndReturnsScalarParam',
            new InjectionParams([], [], [], [
                'param' => 'value',
            ])
        ));
        echo $valueFromItself;
    }
    public function wantsAndEchoesScalarParam($param)
    {
        echo $param;
    }
    public function wantsAndReturnsScalarParam($param)
    {
        return $param;
    }
}
