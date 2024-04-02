<?php declare(strict_types=1);

namespace Builder\Tests\Visitor;

use Builder\Visitor\NumberVisitor;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class NumberVisitorTest extends TestCase
{
    #[DataProvider('provideMatch')]
    public function testMatch(mixed $arg, bool $expected)
    {
        $validator = new NumberVisitor();
        $this->assertEquals($expected, $validator->match($arg));
    }
    public static function provideMatch() : array
    {
        return [
            [1, true],
            ['1', false],
        ];
    }

    #[DataProvider('provideCast')]
    public function testCast(mixed $arg, bool $match, string $expected)
    {
        $mock = $this->getMockBuilder(NumberVisitor::class)
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
            [1, true, '1'],
            [null, false, ''],
        ];
    }
}
