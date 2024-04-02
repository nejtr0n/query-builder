<?php declare(strict_types=1);

namespace Builder\Parser;

use Builder\Lexer\Token;
use Builder\Lexer\TokenType;

class ConditionNode extends QueryNode
{
    private const TokenType SKIP = TokenType::SKIP;
    private bool $haveToSkip = false;

    public function push(Token $token) : void
    {
        if ($token->type == self::SKIP) {
            $this->haveToSkip = true;
        }

        parent::push($token);
    }

    public function bind(): string
    {
        if ($this->haveToSkip) {
            return "";
        }

        return parent::bind();
    }
}