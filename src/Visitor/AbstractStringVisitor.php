<?php declare(strict_types=1);

namespace Builder\Visitor;

use InvalidArgumentException;

abstract class AbstractStringVisitor implements Visitor
{
    #[\Override]
    public function match(mixed $arg): bool
    {
        return is_string($arg);
    }

    #[\Override]
    public function cast(mixed $arg) : string
    {
        return $this->match($arg) ?
            $this->escape(
                sprintf("%s", $arg),
            ) :
            throw new InvalidArgumentException(sprintf("argument should be string, %s given", gettype($arg)));
    }

    // todo: driver specific escape
    private function escape(string $arg) : string
    {
        $search =  ["\\",   "\x00", "\n",  "\r",  "'",  '"', "\x1a"];
        $replace = ["\\\\", "\\0",  "\\n", "\\r", "\'", '\"', "\\Z"];

        return str_replace($search, $replace, $arg);
    }
}
