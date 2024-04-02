<?php declare(strict_types=1);

namespace Builder\Tests\Visitor\Strategy;

use Builder\Visitor\Strategy\ListStrategy;
use Builder\Visitor\Visitor;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ListStrategyTest extends TestCase
{
    #[DataProvider('provideCast')]
    public function testCast(Visitor $visitor, array $args, string $expected)
    {
        $strategy = new ListStrategy($visitor);
        $this->assertEquals($expected, $strategy->cast($args));
    }
    public static function provideCast() : array
    {
        $transparentVisitor = new class() implements Visitor {
            #[\Override]public function match(mixed $arg) : bool
            {
                return true;
            }
            #[\Override]public function cast(mixed $arg) : string
            {
                return $arg;
            }
        };

        return [
            [$transparentVisitor, ['1','2','3'], '1, 2, 3'],
        ];
    }
}
