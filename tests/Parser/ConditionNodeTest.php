<?php declare(strict_types=1);

namespace Builder\Tests\Parser;

use Builder\Lexer\Token;
use Builder\Lexer\TokenType;
use Builder\Parser\ConditionNode;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ConditionNodeTest extends TestCase
{
    #[DataProvider('provideBind')]
    public function testBind(array $tokens, string $expected)
    {
        /** @var ConditionNode $node */
        $node = with(new ConditionNode(), function (ConditionNode $node) use ($tokens): ConditionNode {
            foreach ($tokens as $args) {
                [$type, $bind] = $args;
                $node->push($this->mockToken($type, $bind));
            }

            return $node;
        });
        $this->assertEquals($expected, $node->bind());
    }

    public static function provideBind() : array
    {

        return [
           [[[TokenType::SKIP, ""]], ""],
            [[[TokenType::STRING, "a"]], "a"],
            [[[TokenType::STRING, "a"], [TokenType::STRING, "b"]], "ab"],
            [[[TokenType::STRING, "a"], [TokenType::STRING, "b"], [TokenType::SKIP, ""]], ""],
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
