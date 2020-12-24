<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\PhpDoc;

use _PhpScopere8e811afab72\PHPStan\Analyser\NameScope;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TypeParser;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
class TypeStringResolver
{
    /** @var Lexer */
    private $typeLexer;
    /** @var TypeParser */
    private $typeParser;
    /** @var TypeNodeResolver */
    private $typeNodeResolver;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer $typeLexer, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TypeParser $typeParser, \_PhpScopere8e811afab72\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver)
    {
        $this->typeLexer = $typeLexer;
        $this->typeParser = $typeParser;
        $this->typeNodeResolver = $typeNodeResolver;
    }
    public function resolve(string $typeString, ?\_PhpScopere8e811afab72\PHPStan\Analyser\NameScope $nameScope = null) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $tokens = new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator($this->typeLexer->tokenize($typeString));
        $typeNode = $this->typeParser->parse($tokens);
        $tokens->consumeTokenType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_END);
        return $this->typeNodeResolver->resolve($typeNode, $nameScope ?? new \_PhpScopere8e811afab72\PHPStan\Analyser\NameScope(null, []));
    }
}
