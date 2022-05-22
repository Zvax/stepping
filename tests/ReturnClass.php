<?php declare(strict_types=1);

namespace Stepping\Tests;

use Stepping\Action;
use Stepping\InjectionParams;

function getValue(Foo $foo): string
{
    return 'valueFromInjectorActivatedFunction';
}

class ReturnClass
{
    public function echoOk(): void
    {
        echo 'ok';
    }

    public function getValue(): string
    {
        return 'valueFromClass';
    }

    public function shouldReceiveFromYield(): \Generator
    {
        $valueFromItself = (yield new Action(__CLASS__ . '::getValue'));
        echo $valueFromItself;
    }

    private function getAction(): \Generator
    {
        yield function () {
            echo 'from yield new action';
        };
    }

    public function shouldYieldExecutedFunction(): \Generator
    {
        yield function () {
            echo 'ok';
        };
        $value = (yield null);
        yield new Action(ReturnClass::class . '::echoOk');
        yield $this->getAction();
    }

    public function shouldReceiveFromYieldsCallable(): \Generator
    {
        $valueFromItself = (yield new Action('Stepping\Tests\getValue'));
        echo $valueFromItself;
    }

    public function shouldReceivedSentParamFromYield(): \Generator
    {
        $valueFromItself = (yield new Action(ReturnClass::class . '::wantsAndReturnsScalarParam',
            new InjectionParams([], [], [], [
                'param' => 'value',
            ])));
        echo $valueFromItself;
    }

    public function wantsAndEchoesScalarParam($param): void
    {
        echo $param;
    }

    public function wantsAndReturnsScalarParam($param): mixed
    {
        return $param;
    }
}
