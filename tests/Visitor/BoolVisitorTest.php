<?php declare(strict_types=1);

namespace Builder\Tests\Visitor;

use Builder\Visitor\BoolVisitor;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class BoolVisitorTest extends TestCase
{
    #[DataProvider('provideMatch')]
    public function testMatch(mixed $arg, bool $expected)
    {
        $validator = new BoolVisitor();
        $this->assertEquals($expected, $validator->match($arg));
    }
    public static function provideMatch() : array
    {
        return [
            [true, true],
            [1, false],
        ];
    }

    #[DataProvider('provideCast')]
    public function testCast(mixed $arg, bool $match, string $expected)
    {
        $mock = $this->getMockBuilder(BoolVisitor::class)
            ->onlyMethods(["match"])
            ->getMock();
        $mock->method("match")
            ->willReturn($match);

        if (!$match) {
            $this->expectException(InvalidArgumentException::class);
        }
        $this->assertEquals($expected, $mock->cast($arg));
    }
    public static function provideCast() : array
    {
        return [
            [true, true, '1'],
            [false, true, '0'],
            [1, false, ''],
        ];
    }
}
