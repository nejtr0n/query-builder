<?php declare(strict_types=1);

namespace Builder\Visitor;

interface ArrayVisitorStrategy
{
    public function cast(array $items) : string;
}