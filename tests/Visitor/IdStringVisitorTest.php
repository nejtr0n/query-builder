<?php declare(strict_types=1);

namespace Builder\Tests\Visitor;

use Builder\Visitor\IdStringVisitor;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class IdStringVisitorTest extends TestCase
{
    #[DataProvider('provideCast')]
    public function testCast(mixed $arg, bool $match, string $expected)
    {
        if (!$match) {
            $this->expectException(InvalidArgumentException::class);
        }

        $mock = $this->getMockBuilder(IdStringVisitor::class)
            ->onlyMethods(["match"])
            ->getMock();
        $mock->method("match")
            ->willReturn($match);

        $this->assertEquals($expected, $mock->cast($arg));
    }

    public static function provideCast() : array
    {
        return [
            ['1', true, '`1`'],
            ["1'", true, "`1\'`"],
            [null, false, ''],
        ];
    }
}
