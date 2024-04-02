<?php declare(strict_types=1);

namespace Builder\Visitor;

abstract class AbstractVisitor implements Visitor
{
    use Visitable;

    protected ?Visitor $instance = null;

    public function getInstance() : Visitor
    {
        if (is_null($this->instance)) {
            $this->instance = $this->getVisitor();
        }

        return $this->instance;
    }

    #[\Override]
    public function match(mixed $arg) : bool
    {
        return $this->getInstance()->match($arg);
    }

    #[\Override]
    public function cast(mixed $arg) : string
    {
        return $this->getInstance()->cast($arg);
    }
}
