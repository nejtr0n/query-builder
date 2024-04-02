<?php declare(strict_types=1);

namespace Builder\Parser;

use Builder\Lexer\Token;

class QueryNode implements Node
{
    /**
     * @var Token[]
     */
    protected array $tokens = [];

    #[\Override]
    public function push(Token $token) : void
    {
        $this->tokens[] = $token;
    }

    #[\Override]
    public function bind() : string
    {
        $result = "";

        foreach ($this->tokens as $token) {
            $result .= $token->bind();
        }

        return $result;
    }

    #[\Override]
    public function count(): int
    {
        return count($this->tokens);
    }
}
