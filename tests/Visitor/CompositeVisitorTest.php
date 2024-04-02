<?php declare(strict_types=1);

namespace Builder\Tests\Visitor;

use Builder\Visitor\CompositeVisitor;
use Builder\Visitor\Visitor;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CompositeVisitorTest extends TestCase
{
    #[DataProvider('provideMatch')]
    public function testMatch(bool $expected, Visitor ...$visitors)
    {
        $visitor = new CompositeVisitor(...$visitors);
        $this->assertEquals($expected, $visitor->match("no matter arg"));
    }

    public static function provideMatch() : array
    {
        [$notMatchingVisitor, $matchingVisitor] = self::stubs();

        return [
            [false],
            [false, $notMatchingVisitor],
            [true, $matchingVisitor],
            [true, $notMatchingVisitor, $notMatchingVisitor, $notMatchingVisitor, $matchingVisitor],
        ];
    }

    #[DataProvider('provideCast')]
    public function testCast(bool $throwsException, string $expected, Visitor ...$visitors)
    {
        if ($throwsException) {
            $this->expectException(InvalidArgumentException::class);
        }
        $visitor = new CompositeVisitor(...$visitors);
        $this->assertEquals($expected, $visitor->cast("no matter arg"));
    }

    public static function provideCast() : array
    {
        [$notMatchingVisitor, $matchingVisitor] = self::stubs();

        return [
            [true, ''],
            [true, '', $notMatchingVisitor],
            [false, 'test', $matchingVisitor],
            [false, 'test', $notMatchingVisitor, $notMatchingVisitor, $notMatchingVisitor, $matchingVisitor],
        ];
    }
    private static function stubs(): array
    {
        return [
            new class() implements Visitor {
                #[\Override]
                public function match(mixed $arg): bool
                {
                    return false;
                }

                #[\Override]
                public function cast(mixed $arg): string
                {
                    return '';
                }
            },
            new class() implements Visitor {
                #[\Override]
                public function match(mixed $arg): bool
                {
                    return true;
                }

                #[\Override]
                public function cast(mixed $arg): string
                {
                    return 'test';
                }
            }
        ];
    }
}
