<?php declare(strict_types=1);

namespace Builder\Lexer;

use InvalidArgumentException;
use Iterator;

class ConditionTokenizer extends AbstractTokenizer implements Tokenizer
{
    private string $skip;
    public function __construct(string $skip)
    {
        $this->skip = $skip;
    }
    protected const array STRING_DELIM = [
        ...parent::STRING_DELIM,
        TokenType::RIF->value,
    ];

    public function tokenize(Iterator $iterator, mixed &$args) : ?Token
    {
        if ($iterator->current() == TokenType::LIF->value) {
            throw new InvalidArgumentException("nested conditions are not allowed");
        }

        if ($iterator->current() == TokenType::RIF->value) {
            $iterator->next();
            return new Token(TokenType::RIF);
        }

        $token = parent::tokenize($iterator, $args);
        if ($token instanceof PatternToken && $token->value === $this->skip) {
            return new Token(TokenType::SKIP);
        }

        return $token;
    }
}