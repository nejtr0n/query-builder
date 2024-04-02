<?php declare(strict_types=1);

namespace Builder\Visitor;

use Builder\Attributes\Visitor as VisitorAttributes;

#[VisitorAttributes(
    IdStringVisitor::class,
    IdArrayVisitor::class,
)]
class IdVisitor extends AbstractVisitor
{
}
