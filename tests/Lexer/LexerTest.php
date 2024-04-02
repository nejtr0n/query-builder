<?php declare(strict_types=1);

namespace Builder\Tests\Lexer;

use Builder\Lexer\Lexer;
use Builder\Lexer\Token;
use Builder\Lexer\Tokenizer;
use Builder\Lexer\TokenType;
use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class LexerTest extends TestCase
{
    #[DataProvider('provideGetNextToken')]
    public function testGetNextToken(string $query, array $args, int $expected)
    {
        $tokenizer = new class() implements Tokenizer {
            public int $called = 0;

            #[\Override]
            public function tokenize(Iterator $iterator, mixed &$args): ?Token
            {
                $this->called++;
                $iterator->next();

                return new Token(TokenType::SKIP);
            }
        };
        $lexer = new Lexer($query, $args);
        for ($i = 0; $i < strlen($query)+1; $i++) {
            $lexer->getNextToken($tokenizer);
        }

        $this->assertEquals($expected, $tokenizer->called);
    }

    public static function provideGetNextToken(): array
    {
        return [
            ["", [], 0],
            ["1", [], 1],
        ];
    }
}
