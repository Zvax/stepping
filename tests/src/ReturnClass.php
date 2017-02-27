<?php
namespace Tests;
use Stepping\Action;
use Stepping\InjectionParams;
function getValue(Foo $foo)
{
    return 'valueFromInjectorActivatedFunction';
}
class ReturnClass {
    public function echoOk()
    {
        echo 'ok';
    }
    public function getValue()
    {
        return 'valueFromClass';
    }
    public function shouldReceiveFromYield()
    {
        $valueFromItself = (yield new Action('Tests\ReturnClass::getValue'));
        echo $valueFromItself;
    }
    private function getAction()
    {
        yield function ()
        {
            echo 'from yield new action';
        };
    }
    public function shouldYieldExecutedFunction()
    {
        yield function()
        {
            echo 'ok';
        };
        $value = (yield null);
        yield new Action('Tests\ReturnClass::echoOk');
        yield $this->getAction();
    }
    public function shouldReceiveFromYieldAndReturnAnotherAction()
    {
        $valueFromItself = (yield new Action('Tests\getValue'));
        yield function () use ($valueFromItself)
        {
            echo $valueFromItself;
        };
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
