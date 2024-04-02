<?php declare(strict_types=1);

namespace Builder\Tests\Lexer;

use Builder\Lexer\Token;
use Builder\Lexer\TokenType;
use PHPUnit\Framework\TestCase;

class TokenTest extends TestCase
{

    public function testBind()
    {
        $token = new Token(TokenType::STRING, "1");
        $this->assertEquals("1", $token->bind());
    }
}
