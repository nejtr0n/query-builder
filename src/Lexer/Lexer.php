<?php declare(strict_types=1);

namespace Builder\Lexer;

use ArrayIterator;
use Iterator;

class Lexer
{
    private Iterator $iterator;
    private array $args;

    public function __construct(string $query, array $args)
    {
        $this->iterator = new ArrayIterator(str_split($query));
        $this->args = $args;
    }

    /**
     * Split current query into tokens
     * @param Tokenizer $tokenizer
     * @return Token|null
     */
    public function getNextToken(Tokenizer $tokenizer): ?Token
    {
        if ($this->iterator->valid()) {
            return $tokenizer->tokenize($this->iterator, $this->args);
        }

        return null;
    }
}
