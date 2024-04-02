<?php declare(strict_types=1);

namespace Builder\Lexer;

use Iterator;

interface Tokenizer
{
    public function tokenize(Iterator $iterator,  mixed &$args): ?Token;
}