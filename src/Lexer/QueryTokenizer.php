<?php declare(strict_types=1);

namespace Builder\Lexer;

use InvalidArgumentException;
use Iterator;

class QueryTokenizer extends AbstractTokenizer implements Tokenizer
{
    protected const array STRING_DELIM = [
        ...parent::STRING_DELIM,
        TokenType::LIF->value,
    ];

    public function tokenize(Iterator $iterator,  mixed &$args) : ?Token
    {
        if ($iterator->current() == TokenType::LIF->value) {
            $iterator->next();
            return new Token(TokenType::LIF);
        }

        if ($iterator->current() == TokenType::RIF->value) {
            $iterator->next();
            throw new InvalidArgumentException("unexpected end of condition");
        }

        return parent::tokenize($iterator, $args);
    }
}