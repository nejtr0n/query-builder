<?php declare(strict_types=1);

namespace Builder\Attributes;

use Attribute;
use Builder\Visitor\Visitor as BuilderVisitor;
use Builder\Visitor\CompositeVisitor;
use ReflectionClass;

#[Attribute(Attribute::TARGET_CLASS|Attribute::TARGET_CLASS_CONSTANT)]
readonly class Visitor
{
    public BuilderVisitor $visitor;

    public function __construct(string ...$visitors)
    {
        $result = [];
        foreach ($visitors as $visitor) {
            $result[] = with(new ReflectionClass($visitor))->newInstance();
        }

        $this->visitor = new CompositeVisitor(...$result);
    }
}
