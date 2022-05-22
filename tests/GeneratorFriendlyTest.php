<?php declare(strict_types=1);

namespace Stepping\Tests;

use Auryn\Injector;
use PHPUnit\Framework\TestCase;
use Stepping\Action;
use Stepping\Engine;

class GeneratorFriendlyTest extends TestCase
{
    /** @test */
    public function generators_do_not_duplicate(): void
    {
        $engine = new Engine(new Injector, new Action('Stepping\Tests\startRun'));
        ob_start();
        $engine->execute();
        $string = ob_get_clean();
        self::assertEquals('0123456789', $string);
    }

    /**
     * @test
     * we should be able to receive the product of a step from inside a handler
     */
    public function product_can_be_received_from_yield(): void
    {
        $engine = new Engine(new Injector, new Action(ConsumesYield::class . '::generator'));
        ob_start();
        $engine->execute();
        $content = ob_get_clean();
        self::assertSame('generated product', $content);
    }
}
