<?php declare(strict_types=1);

namespace Builder\Tests\Lexer;

use ArrayIterator;
use Builder\Lexer\ConditionTokenizer;
use Builder\Lexer\Token;
use Builder\Lexer\TokenType;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ConditionTokenizerTest extends TestCase
{
    private const string SKIP = '|';

    #[DataProvider('provideTokenize')]
    public function testTokenize(string $query, array $args, ?Token $expected)
    {
        $tokenizer = new ConditionTokenizer(self::SKIP);
        $this->assertEquals(
            $expected,
            $tokenizer->tokenize(new ArrayIterator(str_split($query)), $args),
        );
    }

    public static function provideTokenize(): array
    {
        return [
            ["", [], null],
            ["}", [], new Token(TokenType::RIF)],
            ["?",[self::SKIP], new Token(TokenType::SKIP)],
        ];
    }

    #[DataProvider('provideTokenizeFails')]
    public function testTokenizeFails(string $query, array $args, string $exception)
    {
        $this->expectException($exception);
        with(new ConditionTokenizer(self::SKIP))
            ->tokenize(new ArrayIterator(str_split($query)), $args);
    }

    public static function provideTokenizeFails(): array
    {
        return [
            ["{", [], InvalidArgumentException::class],
            ["?", [], InvalidArgumentException::class],
        ];
    }
}
