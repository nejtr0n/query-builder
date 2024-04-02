<?php declare(strict_types=1);

namespace Builder\Visitor;

use InvalidArgumentException;

class BoolVisitor implements Visitor
{
    #[\Override]
    public function match(mixed $arg): bool
    {
        return is_bool($arg);
    }

    #[\Override]
    public function cast(mixed $arg) : string
    {
        if (!$this->match($arg)) {
            throw new InvalidArgumentException(sprintf("argument should be bool, %s given", gettype($arg)));
        }

        return $arg ? '1' : '0';
    }
}
