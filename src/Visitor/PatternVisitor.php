<?php declare(strict_types=1);

namespace Builder\Visitor;

use Builder\Attributes\Visitor as VisitorAttributes;

#[VisitorAttributes(
    QuoteStringVisitor::class,
    NumberVisitor::class,
    FloatVisitor::class,
    BoolVisitor::class,
    NullVisitor::class
)]
class PatternVisitor extends AbstractVisitor
{
}
