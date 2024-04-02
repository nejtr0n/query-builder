<?php declare(strict_types=1);

namespace Builder\Visitor;

use InvalidArgumentException;

class FloatVisitor implements Visitor
{
    #[\Override]
    public function match(mixed $arg): bool
    {
        return is_float($arg);
    }

    #[\Override]
    public function cast(mixed $arg) : string
    {
        return $this->match($arg) ?
            sprintf('%f', $arg) :
            throw new InvalidArgumentException(sprintf("argument should be float, %s given", gettype($arg)));
    }
}