<?php declare(strict_types=1);

namespace Builder\Lexer;

use \Builder\Attributes\Visitor;
use Builder\Visitor\ArrayVisitor;
use Builder\Visitor\BoolVisitor;
use Builder\Visitor\FloatVisitor;
use Builder\Visitor\IdVisitor;
use Builder\Visitor\NullVisitor;
use Builder\Visitor\NumberVisitor;
use Builder\Visitor\PatternVisitor;
use Builder\Visitor\QuoteStringVisitor;
use Builder\Visitor\Visitable;

enum TokenType : string
{
    use Visitable;
    case STRING = '';
    #[Visitor(PatternVisitor::class)]
    case PATTERN = '?';
    #[Visitor(NumberVisitor::class, NullVisitor::class)]
    case PATTERN_INT = 'd';
    #[Visitor(FloatVisitor::class, NullVisitor::class)]
    case PATTERN_FLOAT = 'f';
    #[Visitor(ArrayVisitor::class)]
    case PATTERN_ARRAY = 'a';
    #[Visitor(IdVisitor::class)]
    case PATTERN_ID = '#';
    case LIF = '{';
    case RIF = '}';
    case SKIP = '|';
}
