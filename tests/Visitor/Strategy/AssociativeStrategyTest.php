<?php declare(strict_types=1);

namespace Builder\Tests\Visitor\Strategy;

use Builder\Visitor\Strategy\AssociativeStrategy;
use Builder\Visitor\Visitor;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AssociativeStrategyTest extends TestCase
{
    #[DataProvider('provideCast')]
    public function testCast(Visitor $key, Visitor $value, array $args, string $expected)
    {
        $strategy = new AssociativeStrategy($key, $value);
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
            [$transparentVisitor, $transparentVisitor, ['test' => 'test'], 'test = test'],
            [$transparentVisitor, $transparentVisitor, ['test' => 'test', 'a' => '1'], 'test = test, a = 1'],
        ];
    }
}
