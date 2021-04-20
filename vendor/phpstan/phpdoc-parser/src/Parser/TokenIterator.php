<?php

declare (strict_types=1);
namespace PHPStan\PhpDocParser\Parser;

use PHPStan\PhpDocParser\Lexer\Lexer;
class TokenIterator
{
    /** @var mixed[][] */
    private $tokens;
    /** @var int */
    private $index;
    /** @var int[] */
    private $savePoints = [];
    public function __construct(array $tokens, int $index = 0)
    {
        $this->tokens = $tokens;
        $this->index = $index;
        if ($this->tokens[$this->index][\PHPStan\PhpDocParser\Lexer\Lexer::TYPE_OFFSET] !== \PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_HORIZONTAL_WS) {
            return;
        }
        $this->index++;
    }
    public function currentTokenValue() : string
    {
        return $this->tokens[$this->index][\PHPStan\PhpDocParser\Lexer\Lexer::VALUE_OFFSET];
    }
    public function currentTokenType() : int
    {
        return $this->tokens[$this->index][\PHPStan\PhpDocParser\Lexer\Lexer::TYPE_OFFSET];
    }
    public function currentTokenOffset() : int
    {
        $offset = 0;
        for ($i = 0; $i < $this->index; $i++) {
            $offset += \strlen($this->tokens[$i][\PHPStan\PhpDocParser\Lexer\Lexer::VALUE_OFFSET]);
        }
        return $offset;
    }
    public function isCurrentTokenValue(string $tokenValue) : bool
    {
        return $this->tokens[$this->index][\PHPStan\PhpDocParser\Lexer\Lexer::VALUE_OFFSET] === $tokenValue;
    }
    public function isCurrentTokenType(int $tokenType) : bool
    {
        return $this->tokens[$this->index][\PHPStan\PhpDocParser\Lexer\Lexer::TYPE_OFFSET] === $tokenType;
    }
    public function isPrecededByHorizontalWhitespace() : bool
    {
        return ($this->tokens[$this->index - 1][\PHPStan\PhpDocParser\Lexer\Lexer::TYPE_OFFSET] ?? -1) === \PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_HORIZONTAL_WS;
    }
    /**
     * @param  int $tokenType
     * @throws \PHPStan\PhpDocParser\Parser\ParserException
     * @return void
     */
    public function consumeTokenType(int $tokenType)
    {
        if ($this->tokens[$this->index][\PHPStan\PhpDocParser\Lexer\Lexer::TYPE_OFFSET] !== $tokenType) {
            $this->throwError($tokenType);
        }
        $this->index++;
        if (($this->tokens[$this->index][\PHPStan\PhpDocParser\Lexer\Lexer::TYPE_OFFSET] ?? -1) !== \PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_HORIZONTAL_WS) {
            return;
        }
        $this->index++;
    }
    /** @phpstan-impure */
    public function tryConsumeTokenValue(string $tokenValue) : bool
    {
        if ($this->tokens[$this->index][\PHPStan\PhpDocParser\Lexer\Lexer::VALUE_OFFSET] !== $tokenValue) {
            return \false;
        }
        $this->index++;
        if ($this->tokens[$this->index][\PHPStan\PhpDocParser\Lexer\Lexer::TYPE_OFFSET] === \PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_HORIZONTAL_WS) {
            $this->index++;
        }
        return \true;
    }
    /** @phpstan-impure */
    public function tryConsumeTokenType(int $tokenType) : bool
    {
        if ($this->tokens[$this->index][\PHPStan\PhpDocParser\Lexer\Lexer::TYPE_OFFSET] !== $tokenType) {
            return \false;
        }
        $this->index++;
        if ($this->tokens[$this->index][\PHPStan\PhpDocParser\Lexer\Lexer::TYPE_OFFSET] === \PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_HORIZONTAL_WS) {
            $this->index++;
        }
        return \true;
    }
    public function getSkippedHorizontalWhiteSpaceIfAny() : string
    {
        if ($this->index > 0 && $this->tokens[$this->index - 1][\PHPStan\PhpDocParser\Lexer\Lexer::TYPE_OFFSET] === \PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_HORIZONTAL_WS) {
            return $this->tokens[$this->index - 1][\PHPStan\PhpDocParser\Lexer\Lexer::VALUE_OFFSET];
        }
        return '';
    }
    /** @phpstan-impure */
    public function joinUntil(int ...$tokenType) : string
    {
        $s = '';
        while (!\in_array($this->tokens[$this->index][\PHPStan\PhpDocParser\Lexer\Lexer::TYPE_OFFSET], $tokenType, \true)) {
            $s .= $this->tokens[$this->index++][\PHPStan\PhpDocParser\Lexer\Lexer::VALUE_OFFSET];
        }
        return $s;
    }
    /**
     * @return void
     */
    public function next()
    {
        $this->index++;
        if ($this->tokens[$this->index][\PHPStan\PhpDocParser\Lexer\Lexer::TYPE_OFFSET] !== \PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_HORIZONTAL_WS) {
            return;
        }
        $this->index++;
    }
    /** @phpstan-impure
     * @return void */
    public function forwardToTheEnd()
    {
        $lastToken = \count($this->tokens) - 1;
        $this->index = $lastToken;
    }
    /**
     * @return void
     */
    public function pushSavePoint()
    {
        $this->savePoints[] = $this->index;
    }
    /**
     * @return void
     */
    public function dropSavePoint()
    {
        \array_pop($this->savePoints);
    }
    /**
     * @return void
     */
    public function rollback()
    {
        $index = \array_pop($this->savePoints);
        \assert($index !== null);
        $this->index = $index;
    }
    /**
     * @param  int $expectedTokenType
     * @throws \PHPStan\PhpDocParser\Parser\ParserException
     * @return void
     */
    private function throwError(int $expectedTokenType)
    {
        throw new \PHPStan\PhpDocParser\Parser\ParserException($this->currentTokenValue(), $this->currentTokenType(), $this->currentTokenOffset(), $expectedTokenType);
    }
}
