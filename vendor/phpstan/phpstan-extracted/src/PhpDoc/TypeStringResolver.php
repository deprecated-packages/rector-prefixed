<?php

declare (strict_types=1);
namespace PHPStan\PhpDoc;

use PHPStan\Analyser\NameScope;
use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use PHPStan\PhpDocParser\Parser\TypeParser;
use PHPStan\Type\Type;
class TypeStringResolver
{
    /** @var Lexer */
    private $typeLexer;
    /** @var TypeParser */
    private $typeParser;
    /** @var TypeNodeResolver */
    private $typeNodeResolver;
    public function __construct(\PHPStan\PhpDocParser\Lexer\Lexer $typeLexer, \PHPStan\PhpDocParser\Parser\TypeParser $typeParser, \PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver)
    {
        $this->typeLexer = $typeLexer;
        $this->typeParser = $typeParser;
        $this->typeNodeResolver = $typeNodeResolver;
    }
    public function resolve(string $typeString, ?\PHPStan\Analyser\NameScope $nameScope = null) : \PHPStan\Type\Type
    {
        $tokens = new \PHPStan\PhpDocParser\Parser\TokenIterator($this->typeLexer->tokenize($typeString));
        $typeNode = $this->typeParser->parse($tokens);
        $tokens->consumeTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_END);
        return $this->typeNodeResolver->resolve($typeNode, $nameScope ?? new \PHPStan\Analyser\NameScope(null, []));
    }
}
