<?php declare(strict_types=1);

namespace Builder\Parser;

use Builder\Lexer\QueryTokenizer;
use Builder\Lexer\Tokenizer;

class QueryFactory implements AbstractQueryFactory
{
    #[\Override]
    public function getTokenizer() : Tokenizer
    {
        return new QueryTokenizer();
    }
    #[\Override]
    public function getNode() : Node
    {
        return new QueryNode();
    }
}