<?php declare(strict_types=1);

namespace Builder\Interpreter;

use Builder\Parser\Node;
use SplDoublyLinkedList;

class Interpreter
{
    /**
     * @var SplDoublyLinkedList<int,Node> $tree
     */
    private SplDoublyLinkedList $tree;

    public function __construct(SplDoublyLinkedList $tree)
    {
        $this->tree = $tree;
    }

    public function bind(): string
    {
        $result = "";

        $this->tree->rewind();
        while ($this->tree->valid()) {
            $result .= $this->tree->current()->bind();

            $this->tree->next();
        }

        return $result;
    }
}