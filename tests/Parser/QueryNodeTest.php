<?php declare(strict_types=1);

namespace Builder\Tests\Parser;

use Builder\Lexer\Token;
use Builder\Lexer\TokenType;
use Builder\Parser\QueryNode;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class QueryNodeTest extends TestCase
{
    #[DataProvider('provideBind')]
    public function testBind(array $tokens, string $expected)
    {
        /** @var QueryNode $node */
        $node = with(new QueryNode(), function (QueryNode $node) use ($tokens): QueryNode {
            foreach ($tokens as $args) {
                [$type, $bind] = $args;
                $node->push($this->mockToken($type, $bind));
            }

            return $node;
        });
        $this->assertEquals($expected, $node->bind([]));
    }

    public static function provideBind() : array
    {

        return [
            [[[TokenType::SKIP, ""]], ""],
            [[ [TokenType::SKIP, ""], [TokenType::STRING, "a"], [TokenType::STRING, "b"]], "ab"],
        ];
    }
    private function mockToken(TokenType $type, string $bind): Token
    {
        $token = $this->getMockBuilder(Token::class)
            ->disableOriginalConstructor()
            ->getMock();
        $token->type = $type;
        $token->method("bind")->willReturn($bind);

        return $token;
    }
}
