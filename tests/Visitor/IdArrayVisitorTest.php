<?php declare(strict_types=1);

namespace Builder\Tests\Visitor;

use Builder\Visitor\IdArrayVisitor;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class IdArrayVisitorTest extends TestCase
{
    #[DataProvider('provideCast')]
    public function testCast(mixed $arg, bool $match, string $expected)
    {
        if (!$match) {
            $this->expectException(InvalidArgumentException::class);
        }

        $mock = $this->getMockBuilder(IdArrayVisitor::class)
            ->onlyMethods(["match"])
            ->getMock();
        $mock->method("match")
            ->willReturn($match);

        $this->assertEquals($expected, $mock->cast($arg));
    }

    public static function provideCast() : array
    {
        return [
            [[], true, ''],
            [["test"], true, "`test`"],
            [["test1", "test2"], true, "`test1`, `test2`"],
            [null, false, ''],
        ];
    }
}
