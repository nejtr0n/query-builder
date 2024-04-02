<?php declare(strict_types=1);

namespace Builder\Parser;

use Builder\Lexer\Tokenizer;

interface AbstractQueryFactory
{
    public function getTokenizer(): Tokenizer;
    public function getNode(): Node;
}