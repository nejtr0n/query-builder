<?php declare(strict_types=1);

namespace Builder\Parser;

use Builder\Lexer\Token;

interface Node
{
    public function bind(): string;
    public function push(Token $token): void;
    public function count(): int;
}
