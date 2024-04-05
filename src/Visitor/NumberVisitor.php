<?php declare(strict_types=1);

namespace Builder\Visitor;

use InvalidArgumentException;

class NumberVisitor implements Visitor
{
    #[\Override]
    public function match(mixed $arg): bool
    {
        return is_integer($arg);
    }

    #[\Override]
    public function cast(mixed $arg) : string
    {
        return $this->match($arg) ?
            sprintf('%d', $arg) :
            throw new InvalidArgumentException(sprintf("argument should be integer, %s given", gettype($arg)));
    }
}