<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\PhpDoc;

use _PhpScoper0a6b37af0871\PHPStan\Analyser\NameScope;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\TypeParser;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
class TypeStringResolver
{
    /** @var Lexer */
    private $typeLexer;
    /** @var TypeParser */
    private $typeParser;
    /** @var TypeNodeResolver */
    private $typeNodeResolver;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer $typeLexer, \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\TypeParser $typeParser, \_PhpScoper0a6b37af0871\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver)
    {
        $this->typeLexer = $typeLexer;
        $this->typeParser = $typeParser;
        $this->typeNodeResolver = $typeNodeResolver;
    }
    public function resolve(string $typeString, ?\_PhpScoper0a6b37af0871\PHPStan\Analyser\NameScope $nameScope = null) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $tokens = new \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\TokenIterator($this->typeLexer->tokenize($typeString));
        $typeNode = $this->typeParser->parse($tokens);
        $tokens->consumeTokenType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_END);
        return $this->typeNodeResolver->resolve($typeNode, $nameScope ?? new \_PhpScoper0a6b37af0871\PHPStan\Analyser\NameScope(null, []));
    }
}
