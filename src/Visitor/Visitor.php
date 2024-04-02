<?php declare(strict_types=1);

namespace Builder\Visitor;

interface Visitor
{
    public function match(mixed $arg): bool;
    public function cast(mixed $arg) : string;
}
