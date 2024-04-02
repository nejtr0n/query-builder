<?php declare(strict_types=1);

namespace Builder\Lexer;

class PatternToken extends Token
{
    public function bind(): string
    {
        return $this->type->getVisitor()->cast($this->value);
    }
}
