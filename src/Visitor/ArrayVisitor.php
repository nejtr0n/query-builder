<?php declare(strict_types=1);

namespace Builder\Visitor;

use Builder\Visitor\Strategy\AssociativeStrategy;
use Builder\Visitor\Strategy\ListStrategy;
use InvalidArgumentException;

class ArrayVisitor extends AbstractArrayVisitor implements Visitor
{
    #[\Override]
    public function cast(mixed $arg) : string
    {
        if ($this->match($arg)) {
            return $this->getStrategy($arg)->cast($arg);
        }

        throw new InvalidArgumentException(sprintf("argument should be array, %s given", gettype($arg)));
    }

    private function getStrategy(array $args) : ArrayVisitorStrategy
    {
        return array_is_list($args) ?
            new ListStrategy(new PatternVisitor()):
            new AssociativeStrategy(new IdStringVisitor(), new PatternVisitor());
    }
}
