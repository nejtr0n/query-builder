<?php declare(strict_types=1);

namespace Builder\Lexer;

use InvalidArgumentException;
use Iterator;

abstract class AbstractTokenizer
{
    protected const array STRING_DELIM = [
        TokenType::PATTERN->value,
    ];

    public function tokenize(Iterator $iterator, mixed &$args) : ?Token
    {
        if (!$iterator->valid()) {
            return null;
        }

        if (!in_array($iterator->current(), static::STRING_DELIM)) {
            return new Token(TokenType::STRING, $this->string($iterator));
        }
        if ($iterator->current() == TokenType::PATTERN->value) {
            $iterator->next();

            $arg = array_shift($args);
            if (is_null($arg)) {
                throw new InvalidArgumentException("please provide argument to pattern");
            }

            if ($iterator->current() == TokenType::PATTERN_INT->value) {
                $iterator->next();
                return new PatternToken(TokenType::PATTERN_INT, $arg);
            }

            if ($iterator->current() == TokenType::PATTERN_FLOAT->value) {
                $iterator->next();
                return new PatternToken(TokenType::PATTERN_FLOAT, $arg);
            }

            if ($iterator->current() == TokenType::PATTERN_ARRAY->value) {
                $iterator->next();
                return new PatternToken(TokenType::PATTERN_ARRAY, $arg);
            }

            if ($iterator->current() == TokenType::PATTERN_ID->value) {
                $iterator->next();
                return new PatternToken(TokenType::PATTERN_ID, $arg);
            }

            return new PatternToken(TokenType::PATTERN, $arg);
        }
    }

    private function string(Iterator $iterator) : string
    {
        $result = "";
        while ($iterator->current() !== null && !in_array($iterator->current(), static::STRING_DELIM)) {
            $result .= $iterator->current();
            $iterator->next();
        }
        return $result;
    }
}