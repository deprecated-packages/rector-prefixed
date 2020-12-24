<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\PhpDoc;

use _PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TypeParser;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
class TypeStringResolver
{
    /** @var Lexer */
    private $typeLexer;
    /** @var TypeParser */
    private $typeParser;
    /** @var TypeNodeResolver */
    private $typeNodeResolver;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer $typeLexer, \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TypeParser $typeParser, \_PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver)
    {
        $this->typeLexer = $typeLexer;
        $this->typeParser = $typeParser;
        $this->typeNodeResolver = $typeNodeResolver;
    }
    public function resolve(string $typeString, ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope $nameScope = null) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $tokens = new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TokenIterator($this->typeLexer->tokenize($typeString));
        $typeNode = $this->typeParser->parse($tokens);
        $tokens->consumeTokenType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_END);
        return $this->typeNodeResolver->resolve($typeNode, $nameScope ?? new \_PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope(null, []));
    }
}
