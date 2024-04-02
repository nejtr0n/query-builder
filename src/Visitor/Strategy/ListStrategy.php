<?php declare(strict_types=1);

namespace Builder\Visitor\Strategy;

use Builder\Visitor\ArrayVisitorStrategy;
use Builder\Visitor\Visitor;

class ListStrategy implements ArrayVisitorStrategy
{
    private Visitor $visitor;

    public function __construct(Visitor $visitor)
    {
        $this->visitor = $visitor;
    }

    #[\Override]
    public function cast(array $items) : string
    {
        $result = [];
        foreach ($items as $value) {
            $result[] = $this->visitor->cast($value);
        }

        return implode(", ", $result);
    }
}
