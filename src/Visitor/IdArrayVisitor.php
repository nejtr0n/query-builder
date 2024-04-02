<?php declare(strict_types=1);

namespace Builder\Visitor;

use Builder\Visitor\Strategy\ListStrategy;
use InvalidArgumentException;

class IdArrayVisitor extends AbstractArrayVisitor
{
    #[\Override]
    public function cast(mixed $arg) : string
    {
        if ($this->match($arg)) {
            return with(new ListStrategy(new IdStringVisitor()))
                ->cast($arg);
        }

        throw new InvalidArgumentException(sprintf("argument should be array, %s given", gettype($arg)));
    }
}