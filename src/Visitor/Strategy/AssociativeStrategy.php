<?php declare(strict_types=1);

namespace Builder\Visitor\Strategy;


use Builder\Visitor\ArrayVisitorStrategy;
use Builder\Visitor\Visitor;

class AssociativeStrategy implements ArrayVisitorStrategy
{
    private Visitor $key;
    private Visitor $value;

    public function __construct(Visitor $key, Visitor $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    #[\Override]
    public function cast(array $items) : string
    {
        $result = [];
        foreach ($items as $key => $value) {
            $result[] = sprintf(
                "%s = %s",
                $this->key->cast($key),
                $this->value->cast($value),
            );
        }

        return implode(", ", $result);
    }
}