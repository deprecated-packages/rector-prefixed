<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\PhpDoc;

use RectorPrefix20201227\PHPStan\Analyser\NameScope;
use RectorPrefix20201227\PHPStan\PhpDocParser\Lexer\Lexer;
use RectorPrefix20201227\PHPStan\PhpDocParser\Parser\TokenIterator;
use RectorPrefix20201227\PHPStan\PhpDocParser\Parser\TypeParser;
use PHPStan\Type\Type;
class TypeStringResolver
{
    /** @var Lexer */
    private $typeLexer;
    /** @var TypeParser */
    private $typeParser;
    /** @var TypeNodeResolver */
    private $typeNodeResolver;
    public function __construct(\RectorPrefix20201227\PHPStan\PhpDocParser\Lexer\Lexer $typeLexer, \RectorPrefix20201227\PHPStan\PhpDocParser\Parser\TypeParser $typeParser, \RectorPrefix20201227\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver)
    {
        $this->typeLexer = $typeLexer;
        $this->typeParser = $typeParser;
        $this->typeNodeResolver = $typeNodeResolver;
    }
    public function resolve(string $typeString, ?\RectorPrefix20201227\PHPStan\Analyser\NameScope $nameScope = null) : \PHPStan\Type\Type
    {
        $tokens = new \RectorPrefix20201227\PHPStan\PhpDocParser\Parser\TokenIterator($this->typeLexer->tokenize($typeString));
        $typeNode = $this->typeParser->parse($tokens);
        $tokens->consumeTokenType(\RectorPrefix20201227\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_END);
        return $this->typeNodeResolver->resolve($typeNode, $nameScope ?? new \RectorPrefix20201227\PHPStan\Analyser\NameScope(null, []));
    }
}
