<?php declare(strict_types=1);

namespace Builder\Visitor;

abstract class AbstractArrayVisitor implements Visitor
{
    #[\Override]
    public function match(mixed $arg) : bool
    {
        return is_array($arg);
    }
}
