<?php declare(strict_types=1);

namespace Builder\Tests\Visitor;

use Builder\Visitor\ArrayVisitor;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ArrayVisitorTest extends TestCase
{
    #[DataProvider('provideMatch')]
    public function testMatch(mixed $arg, bool $expected)
    {
        $validator = new ArrayVisitor();
        $this->assertEquals($expected, $validator->match($arg));
    }

    public static function provideMatch() : array
    {
        return [
            [[], true],
            [1, false],
        ];
    }

    #[DataProvider('provideCast')]
    public function testCast(array $arg, string $expected)
    {
        $validator = new ArrayVisitor();
        $this->assertEquals($expected, $validator->cast($arg));
    }

    public static function provideCast() : array
    {
        return [
            [[], ''],
            [[1], '1'],
            [[1,2], '1, 2'],
            [[null], 'NULL'],
            [[1,null], "1, NULL"],
            [['1',null], "'1', NULL"],
            [[1.2,null], '1.200000, NULL'],
            [[false,null], '0, NULL'],
            [['test' => 'test'], "`test` = 'test'"]
        ];
    }

    public function testCastFails()
    {
        $validator = new ArrayVisitor();
        $this->expectException(InvalidArgumentException::class);
        $validator->cast("");
    }
}
