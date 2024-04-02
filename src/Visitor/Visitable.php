<?php declare(strict_types=1);

namespace Builder\Visitor;

use Builder\Attributes\Visitor as VisitorAttribute;
use BadMethodCallException;
use ReflectionClass;

trait Visitable
{
   public function getVisitor() : Visitor
    {
        $reflection = new ReflectionClass($this);
        if ($reflection->isEnum()) {
            $reflection = $reflection->getReflectionConstant($this->name);
        }
        $attributes = $reflection->getAttributes(
            VisitorAttribute::class,
        );
        if (count($attributes) > 0) {
            return $attributes[0]->newInstance()->visitor;
        }

        throw new BadMethodCallException(
            sprintf("object do not have %s attribute", VisitorAttribute::class),
        );
    }
}
