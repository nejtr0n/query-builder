<?php declare(strict_types=1);

namespace Builder\Parser;

use Builder\Lexer\ConditionTokenizer;
use Builder\Lexer\Tokenizer;

class ConditionFactory implements AbstractQueryFactory
{
    private string $skip;
    public function __construct(string $skip)
    {
        $this->skip = $skip;
    }
    #[\Override]
    public function getTokenizer() : Tokenizer
    {
        return new ConditionTokenizer($this->skip);
    }
    #[\Override]
    public function getNode() : Node
    {
        return new ConditionNode();
    }
}