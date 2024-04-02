<?php declare(strict_types=1);

namespace Builder\Tests\Visitor;

use Builder\Visitor\AbstractStringVisitor;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AbstractStringVisitorTest extends TestCase
{
    #[DataProvider('provideMatch')]
    public function testMatch(mixed $arg, bool $expected)
    {
        $visitor = new class() extends AbstractStringVisitor {};
        $this->assertEquals($expected, $visitor->match($arg));
    }

    public static function provideMatch() : array
    {
        return [
            ['1', true],
            [1, false],
        ];
    }
}
