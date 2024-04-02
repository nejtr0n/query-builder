<?php declare(strict_types=1);

namespace Builder\Tests\Lexer;

use ArrayIterator;
use Builder\Lexer\QueryTokenizer;
use Builder\Lexer\Token;
use Builder\Lexer\TokenType;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class QueryTokenizerTest extends TestCase
{
    #[DataProvider('provideTokenize')]
    public function testTokenize(string $query, array $args, ?Token $expected)
    {
        $tokenizer = new QueryTokenizer();
        $this->assertEquals($expected, $tokenizer->tokenize(new ArrayIterator(str_split($query)), $args));
    }

    public static function provideTokenize(): array
    {
        return [
            ["", [], null],
            ["test", [], new Token(TokenType::STRING, "test")],
            ["{", [], new Token(TokenType::LIF)],
        ];
    }

    #[DataProvider('provideTokenizeFails')]
    public function testTokenizeFails(string $query, array $args, string $exception)
    {
        $this->expectException($exception);
        with(new QueryTokenizer())
            ->tokenize(new ArrayIterator(str_split($query)), $args);
    }

    public static function provideTokenizeFails(): array
    {
        return [
            ["}", [], InvalidArgumentException::class],
        ];
    }
}
