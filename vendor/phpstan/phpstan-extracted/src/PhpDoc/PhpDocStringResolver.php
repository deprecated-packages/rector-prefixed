<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc;

use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\TokenIterator;
class PhpDocStringResolver
{
    /** @var Lexer */
    private $phpDocLexer;
    /** @var PhpDocParser */
    private $phpDocParser;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Lexer\Lexer $phpDocLexer, \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\PhpDocParser $phpDocParser)
    {
        $this->phpDocLexer = $phpDocLexer;
        $this->phpDocParser = $phpDocParser;
    }
    public function resolve(string $phpDocString) : \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode
    {
        $tokens = new \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\TokenIterator($this->phpDocLexer->tokenize($phpDocString));
        $phpDocNode = $this->phpDocParser->parse($tokens);
        $tokens->consumeTokenType(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_END);
        return $phpDocNode;
    }
}
