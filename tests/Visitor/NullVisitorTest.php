<?php declare(strict_types=1);

namespace Builder\Tests\Visitor;

use Builder\Visitor\NullVisitor;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class NullVisitorTest extends TestCase
{

    #[DataProvider('provideMatch')]
    public function testMatch(mixed $arg, bool $expected)
    {
        $validator = new NullVisitor();
        $this->assertEquals($expected, $validator->match($arg));
    }
    public static function provideMatch() : array
    {
        return [
            [null, true],
            ['1', false],
        ];
    }

    #[DataProvider('provideCast')]
    public function testCast(mixed $arg, bool $match, string $expected)
    {
        $mock = $this->getMockBuilder(NullVisitor::class)
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
            [null, true, 'NULL'],
            [1, false, ''],
        ];
    }
}
