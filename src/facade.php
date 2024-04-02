<?php declare(strict_types=1);

use Builder\Interpreter\Interpreter;
use Builder\Lexer\Lexer;
use Builder\Parser\Parser;

if (! function_exists('buildQuery')) {
    /**
     * @param string $query
     * @param string $skip
     * @param array $args
     * @return string
     * @throws Exception
     */
    function buildQuery(string $query, string $skip, array $args = []): string
    {
        $lexer = new Lexer($query, $args);
        $parser = new Parser($lexer, $skip);
        $interpreter = new Interpreter($parser->parse());
        return $interpreter->bind();
    }
}