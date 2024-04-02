<?php declare(strict_types=1);

namespace Builder\Tests\Parser;

use Builder\Lexer\Lexer;
use Builder\Lexer\Token;
use Builder\Lexer\TokenType;
use Builder\Parser\ConditionNode;
use Builder\Parser\Parser;
use Builder\Parser\QueryNode;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SplDoublyLinkedList;

class ParserTest extends TestCase
{
    #[DataProvider('provideParse')]
    public function testParse(array $tokens, SplDoublyLinkedList $expected)
    {
        $mock = $this->getMockBuilder(Lexer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mock->expects($this->any())
            ->method("getNextToken")
            ->willReturnOnConsecutiveCalls(...$tokens);

        $parser = new Parser($mock, "!");
        $this->assertEquals($expected->serialize(), $parser->parse()->serialize());
    }

    public static function provideParse() : array
    {
        return [
            [[], new SplDoublyLinkedList()],
            [[new Token(TokenType::LIF)], new SplDoublyLinkedList()],
            [[new Token(TokenType::RIF)], new SplDoublyLinkedList()],
            [
                [
                    new Token(TokenType::STRING,"a"),
                ],
                with(new SplDoublyLinkedList(), function (SplDoublyLinkedList $parsed) {
                    $parsed->push(with(new QueryNode(), function (QueryNode $node) {
                        $node->push(new Token(TokenType::STRING,"a"));

                        return $node;
                    }));

                    return $parsed;
                })
            ],
            [
                [
                    new Token(TokenType::STRING,"a"),
                    new Token(TokenType::LIF),
                ],
                with(new SplDoublyLinkedList(), function (SplDoublyLinkedList $parsed) {
                    $parsed->push(with(new QueryNode(), function (QueryNode $node) {
                        $node->push(new Token(TokenType::STRING,"a"));

                        return $node;
                    }));

                    return $parsed;
                })
            ],
            [
                [
                    new Token(TokenType::STRING,"a"),
                    new Token(TokenType::LIF),
                    new Token(TokenType::STRING,"b"),
                ],
                with(new SplDoublyLinkedList(), function (SplDoublyLinkedList $parsed) {
                    $parsed->push(with(new QueryNode(), function (QueryNode $node) {
                        $node->push(new Token(TokenType::STRING,"a"));

                        return $node;
                    }));

                    $parsed->push(with(new ConditionNode(), function (ConditionNode $node) {
                        $node->push(new Token(TokenType::STRING,"b"));

                        return $node;
                    }));

                    return $parsed;
                })
            ],
            [
                [
                    new Token(TokenType::STRING,"a"),
                    new Token(TokenType::LIF),
                    new Token(TokenType::STRING,"b"),
                    new Token(TokenType::RIF),
                ],
                with(new SplDoublyLinkedList(), function (SplDoublyLinkedList $parsed) {
                    $parsed->push(with(new QueryNode(), function (QueryNode $node) {
                        $node->push(new Token(TokenType::STRING,"a"));

                        return $node;
                    }));

                    $parsed->push(with(new ConditionNode(), function (ConditionNode $node) {
                        $node->push(new Token(TokenType::STRING,"b"));

                        return $node;
                    }));

                    return $parsed;
                })
            ],
            [
                [
                    new Token(TokenType::STRING,"a"),
                    new Token(TokenType::LIF),
                    new Token(TokenType::STRING,"b"),
                    new Token(TokenType::RIF),
                    new Token(TokenType::STRING,"c"),
                ],
                with(new SplDoublyLinkedList(), function (SplDoublyLinkedList $parsed) {
                    $parsed->push(with(new QueryNode(), function (QueryNode $node) {
                        $node->push(new Token(TokenType::STRING,"a"));

                        return $node;
                    }));

                    $parsed->push(with(new ConditionNode(), function (ConditionNode $node) {
                        $node->push(new Token(TokenType::STRING,"b"));

                        return $node;
                    }));

                    $parsed->push(with(new QueryNode(), function (QueryNode $node) {
                        $node->push(new Token(TokenType::STRING,"c"));

                        return $node;
                    }));

                    return $parsed;
                })
            ],
        ];
    }
}
