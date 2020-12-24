<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo;

use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\TokenIterator;
final class TokenIteratorFactory
{
    /**
     * @var Lexer
     */
    private $lexer;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer $lexer)
    {
        $this->lexer = $lexer;
    }
    public function create(string $content) : \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\TokenIterator
    {
        $tokens = $this->lexer->tokenize($content);
        return new \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\TokenIterator($tokens);
    }
}
