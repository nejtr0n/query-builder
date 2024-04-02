<?php declare(strict_types=1);

namespace Builder\Tests\Interpreter;

use Builder\Interpreter\Interpreter;
use Builder\Parser\Node;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SplDoublyLinkedList;

class InterpreterTest extends TestCase
{
    #[DataProvider('provideBind')]
    public function testBind(int $times, string $expected)
    {
        $node = $this->getMockBuilder(Node::class)
            ->disableOriginalConstructor()
            ->getMock();
        $node->method("bind")->willReturn("a");

        $list = new SplDoublyLinkedList();
        for ($i = 0; $i < $times; $i++) {
            $list->push($node);
        }
        $list->rewind();

        $interpreter = new Interpreter($list);
        $this->assertEquals($expected, $interpreter->bind());
    }

    public static function provideBind() : array
    {
        return [
            [0, ""],
            [1, "a"],
            [10, "aaaaaaaaaa"],
        ];
    }
}
