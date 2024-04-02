<?php declare(strict_types=1);

namespace Builder\Lexer;

class Token
{
    public TokenType $type;
    public mixed $value;

    public function __construct(TokenType $type, $value = null)
    {
        $this->type = $type;
        $this->value = $value;
    }

    public function bind(): string
    {
        return $this->value;
    }
}
