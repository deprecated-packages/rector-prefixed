<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\PhpDoc;

use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use RectorPrefix20201227\PHPStan\PhpDocParser\Lexer\Lexer;
use RectorPrefix20201227\PHPStan\PhpDocParser\Parser\PhpDocParser;
use RectorPrefix20201227\PHPStan\PhpDocParser\Parser\TokenIterator;
class PhpDocStringResolver
{
    /** @var Lexer */
    private $phpDocLexer;
    /** @var PhpDocParser */
    private $phpDocParser;
    public function __construct(\RectorPrefix20201227\PHPStan\PhpDocParser\Lexer\Lexer $phpDocLexer, \RectorPrefix20201227\PHPStan\PhpDocParser\Parser\PhpDocParser $phpDocParser)
    {
        $this->phpDocLexer = $phpDocLexer;
        $this->phpDocParser = $phpDocParser;
    }
    public function resolve(string $phpDocString) : \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode
    {
        $tokens = new \RectorPrefix20201227\PHPStan\PhpDocParser\Parser\TokenIterator($this->phpDocLexer->tokenize($phpDocString));
        $phpDocNode = $this->phpDocParser->parse($tokens);
        $tokens->consumeTokenType(\RectorPrefix20201227\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_END);
        return $phpDocNode;
    }
}
