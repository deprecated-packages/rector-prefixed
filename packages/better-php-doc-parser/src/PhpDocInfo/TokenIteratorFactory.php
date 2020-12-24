<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator;
final class TokenIteratorFactory
{
    /**
     * @var Lexer
     */
    private $lexer;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer $lexer)
    {
        $this->lexer = $lexer;
    }
    public function create(string $content) : \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator
    {
        $tokens = $this->lexer->tokenize($content);
        return new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator($tokens);
    }
}
