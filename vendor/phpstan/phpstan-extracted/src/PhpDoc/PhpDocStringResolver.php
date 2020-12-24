<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\PhpDoc;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator;
class PhpDocStringResolver
{
    /** @var Lexer */
    private $phpDocLexer;
    /** @var PhpDocParser */
    private $phpDocParser;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer $phpDocLexer, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\PhpDocParser $phpDocParser)
    {
        $this->phpDocLexer = $phpDocLexer;
        $this->phpDocParser = $phpDocParser;
    }
    public function resolve(string $phpDocString) : \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode
    {
        $tokens = new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator($this->phpDocLexer->tokenize($phpDocString));
        $phpDocNode = $this->phpDocParser->parse($tokens);
        $tokens->consumeTokenType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_END);
        return $phpDocNode;
    }
}
