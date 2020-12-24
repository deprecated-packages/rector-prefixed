<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\SimplePhpDocParser;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScopere8e811afab72\Symplify\SimplePhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode;
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
    public function __construct(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\PhpDocParser $phpDocParser, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer $lexer)
    {
        $this->phpDocParser = $phpDocParser;
        $this->lexer = $lexer;
    }
    public function parseDocBlock(string $docBlock) : \_PhpScopere8e811afab72\Symplify\SimplePhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode
    {
        $tokens = $this->lexer->tokenize($docBlock);
        $tokenIterator = new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator($tokens);
        $phpDocNode = $this->phpDocParser->parse($tokenIterator);
        return new \_PhpScopere8e811afab72\Symplify\SimplePhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode($phpDocNode->children);
    }
}
