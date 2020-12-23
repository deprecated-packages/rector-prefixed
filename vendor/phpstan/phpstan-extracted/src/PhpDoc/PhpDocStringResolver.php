<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\PhpDoc;

use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Parser\TokenIterator;
class PhpDocStringResolver
{
    /** @var Lexer */
    private $phpDocLexer;
    /** @var PhpDocParser */
    private $phpDocParser;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Lexer\Lexer $phpDocLexer, \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Parser\PhpDocParser $phpDocParser)
    {
        $this->phpDocLexer = $phpDocLexer;
        $this->phpDocParser = $phpDocParser;
    }
    public function resolve(string $phpDocString) : \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode
    {
        $tokens = new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Parser\TokenIterator($this->phpDocLexer->tokenize($phpDocString));
        $phpDocNode = $this->phpDocParser->parse($tokens);
        $tokens->consumeTokenType(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_END);
        return $phpDocNode;
    }
}
