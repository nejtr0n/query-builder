<?php declare(strict_types=1);

namespace Builder\Tests\Visitor;

use Builder\Visitor\IdVisitor;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class IdVisitorTest extends TestCase
{
    #[DataProvider('provideCast')]
    public function testCast(mixed $arg, bool $match, string $expected)
    {
        if (!$match) {
            $this->expectException(InvalidArgumentException::class);
        }

        $visitor = new IdVisitor();
        $this->assertEquals($expected, $visitor->cast($arg));
    }

    public static function provideCast() : array
    {
        return [
            ['', false, ''],
            ['1', true, '`1`'],
            [[], true, ''],
            [[1], false, ''],
            [["test"], true, '`test`'],
            [["test", "test"], true, '`test`, `test`'],
            [1, false, ''],
        ];
    }
}
