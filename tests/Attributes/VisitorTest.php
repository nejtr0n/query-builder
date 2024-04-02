<?php declare(strict_types=1);

namespace Builder\Tests\Attributes;

use Builder\Attributes\Visitor;
use Builder\Visitor\Visitor as BuilderVisitor;
use Builder\Visitor\CompositeVisitor;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use TypeError;

class VisitorTest extends TestCase
{

    #[DataProvider('provideVisitorConstruct')]
    public function testVisitorConstruct(array $visitors, ?string $exception, BuilderVisitor $expected)
    {
        if (!empty($exception)) {
            $this->expectException($exception);
        }

        $attribute = new Visitor(...$visitors);
        $this->assertEquals($expected, $attribute->visitor);
    }

    public static function provideVisitorConstruct() : array
    {
        $goodVisitor = new class() implements BuilderVisitor {
            #[\Override]
            public function match(mixed $arg) : bool
            {
                return true;
            }
            #[\Override]
            public function cast(mixed $arg) : string
            {
                return 'test';
            }
        };

        return [
            [[], null, new CompositeVisitor()],
            [[$goodVisitor::class], null, new CompositeVisitor($goodVisitor)],
            [['a'], ReflectionException::class, new CompositeVisitor()],
            [[with(new class() {})::class], TypeError::class, new CompositeVisitor()],
        ];
    }
}
