<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo;

use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\TokenIterator;
final class TokenIteratorFactory
{
    /**
     * @var Lexer
     */
    private $lexer;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Lexer\Lexer $lexer)
    {
        $this->lexer = $lexer;
    }
    public function create(string $content) : \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\TokenIterator
    {
        $tokens = $this->lexer->tokenize($content);
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\TokenIterator($tokens);
    }
}
