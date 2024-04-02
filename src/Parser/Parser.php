<?php declare(strict_types=1);

namespace Builder\Parser;

use Builder\Lexer\Lexer;
use Builder\Lexer\Token;
use Builder\Lexer\Tokenizer;
use Builder\Lexer\TokenType;
use Exception;
use SplDoublyLinkedList;

class Parser
{
    private Lexer $lexer;
    private Tokenizer $currentTokenizer;
    private ?Node $currentNode = null;
    private ?Token $currentToken;
    private SplDoublyLinkedList $parsed;
    private string $skip;

    public function __construct(Lexer $lexer, string $skip)
    {
        $this->lexer = $lexer;
        $this->skip = $skip;
        $this->parsed = new SplDoublyLinkedList();
        $this->enterQuery();
        $this->currentToken = $lexer->getNextToken(
            $this->currentTokenizer,
        );
    }

    /**
     * @return SplDoublyLinkedList
     * @throws Exception
     */
    public function parse() : SplDoublyLinkedList
    {
        while ($this->currentToken !== null) {
            $token = $this->getToken();
            if (!in_array($token->type, [TokenType::LIF, TokenType::RIF])) {
                $this->currentNode->push($token);
            }
        }

        $this->switchNode();
        return $this->parsed;
    }

    /**
     * @return Token
     * @throws Exception
     */
    private function getToken(): Token
    {
        $token = $this->currentToken;

        if ($token->type == TokenType::LIF) {
            $this->switchNode();
            $this->enterCondition();
        }

        if ($token->type == TokenType::RIF) {
            $this->switchNode();
            $this->enterQuery();
        }

        $this->eat($token->type);

        return $token;
    }

    private function enterQuery(): void
    {
        $this->switchFactory(new QueryFactory());
    }

    private function enterCondition(): void
    {
        $this->switchFactory(new ConditionFactory($this->skip));
    }

    private function switchFactory(AbstractQueryFactory $factory): void
    {
        $this->currentTokenizer = $factory->getTokenizer();
        $this->currentNode = $factory->getNode();
    }

    private function switchNode(): void
    {
        if ($this->currentNode?->count() > 0) {
            $this->parsed->push($this->currentNode);
        }
    }

    /**
     * @param TokenType $type
     * @return void
     * @throws Exception
     */
    private function eat(TokenType $type): void
    {
        if ($this->currentToken->type == $type) {
            $this->currentToken = $this->lexer->getNextToken(
                $this->currentTokenizer,
            );
        } else {
            throw new Exception("Invalid token");
        }
    }
}