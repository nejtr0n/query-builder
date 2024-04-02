<?php declare(strict_types=1);

namespace Builder\Visitor;

class QuoteStringVisitor extends AbstractStringVisitor implements Visitor
{
    #[\Override]
    public function cast(mixed $arg) : string
    {
        return sprintf("'%s'", parent::cast($arg));
    }
}
