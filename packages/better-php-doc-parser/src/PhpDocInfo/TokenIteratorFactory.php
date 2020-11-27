<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocInfo;

use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\TokenIterator;
final class TokenIteratorFactory
{
    /**
     * @var Lexer
     */
    private $lexer;
    public function __construct(\PHPStan\PhpDocParser\Lexer\Lexer $lexer)
    {
        $this->lexer = $lexer;
    }
    public function create(string $content) : \PHPStan\PhpDocParser\Parser\TokenIterator
    {
        $tokens = $this->lexer->tokenize($content);
        return new \PHPStan\PhpDocParser\Parser\TokenIterator($tokens);
    }
}
