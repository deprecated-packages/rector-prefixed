<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\SimplePhpDocParser;

use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScoper0a6b37af0871\Symplify\SimplePhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode;
/**
 * @see \Symplify\SimplePhpDocParser\Tests\SimplePhpDocParser\SimplePhpDocParserTest
 */
final class SimplePhpDocParser
{
    /**
     * @var PhpDocParser
     */
    private $phpDocParser;
    /**
     * @var Lexer
     */
    private $lexer;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\PhpDocParser $phpDocParser, \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer $lexer)
    {
        $this->phpDocParser = $phpDocParser;
        $this->lexer = $lexer;
    }
    public function parseDocBlock(string $docBlock) : \_PhpScoper0a6b37af0871\Symplify\SimplePhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode
    {
        $tokens = $this->lexer->tokenize($docBlock);
        $tokenIterator = new \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\TokenIterator($tokens);
        $phpDocNode = $this->phpDocParser->parse($tokenIterator);
        return new \_PhpScoper0a6b37af0871\Symplify\SimplePhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode($phpDocNode->children);
    }
}
