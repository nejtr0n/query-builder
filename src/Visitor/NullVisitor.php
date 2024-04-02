<?php declare(strict_types=1);

namespace Builder\Visitor;

use InvalidArgumentException;

class NullVisitor implements Visitor
{
    #[\Override]
    public function match(mixed $arg): bool
    {
        return is_null($arg);
    }

    #[\Override]
    public function cast(mixed $arg) : string
    {
        return $this->match($arg) ?
            'NULL' :
            throw new InvalidArgumentException(sprintf("argument should be null, %s given", gettype($arg)));
    }
}
