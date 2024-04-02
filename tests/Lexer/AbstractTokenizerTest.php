<?php declare(strict_types=1);

namespace Builder\Tests\Lexer;

use ArrayIterator;
use Builder\Lexer\AbstractTokenizer;
use Builder\Lexer\PatternToken;
use Builder\Lexer\Token;
use Builder\Lexer\TokenType;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AbstractTokenizerTest extends TestCase
{

    #[DataProvider('provideTokenize')]
    public function testTokenize(string $query, array $args, ?Token $expected)
    {
        $iterator = new ArrayIterator(str_split($query));
        $tokenizer = new class() extends AbstractTokenizer{};
        $this->assertEquals($expected, $tokenizer->tokenize($iterator, $args));
    }

    public static function provideTokenize(): array
    {
        return [
            ["", [], null],
            ["a", [], new Token(TokenType::STRING, "a")],
            ["aa", [], new Token(TokenType::STRING, "aa")],
            ["?", [true], new PatternToken(TokenType::PATTERN, true)],
            ["?d", [1], new PatternToken(TokenType::PATTERN_INT, 1)],
            ["?f", [1.0], new PatternToken(TokenType::PATTERN_FLOAT, 1.0)],
            ["?a", [[1]], new PatternToken(TokenType::PATTERN_ARRAY, [1])],
            ["?#", [["test" => 123]], new PatternToken(TokenType::PATTERN_ID, ["test" => 123])],
        ];
    }
}
