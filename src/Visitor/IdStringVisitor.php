<?php declare(strict_types=1);

namespace Builder\Visitor;

use InvalidArgumentException;

class IdStringVisitor extends AbstractStringVisitor implements Visitor
{
    #[\Override]
    public function cast(mixed $arg) : string
    {
        if ($this->match($arg) && strlen($arg) > 0) {
            return sprintf("`%s`", parent::cast($arg));
        }

        throw new InvalidArgumentException("id string could not be empty");
    }
}
