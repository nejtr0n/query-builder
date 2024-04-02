<?php declare(strict_types=1);

namespace Builder\Visitor;

use InvalidArgumentException;

class CompositeVisitor implements Visitor
{
    private array $visitors;

    public function __construct(Visitor ...$visitors)
    {
        $this->visitors = $visitors;
    }

    #[\Override]
    public function match(mixed $arg) : bool
    {
        foreach ($this->visitors as $visitor) {
            if ($visitor->match($arg)) {
                return true;
            }
        }

        return false;
    }

    #[\Override]
    public function cast(mixed $arg) : string
    {
        foreach ($this->visitors as $visitor) {
            if ($visitor->match($arg)) {
                return $visitor->cast($arg);
            }
        }

        throw new InvalidArgumentException("argument does not match any visitor");
    }
}
