<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo;

use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TokenIterator;
final class TokenIteratorFactory
{
    /**
     * @var Lexer
     */
    private $lexer;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer $lexer)
    {
        $this->lexer = $lexer;
    }
    public function create(string $content) : \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TokenIterator
    {
        $tokens = $this->lexer->tokenize($content);
        return new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TokenIterator($tokens);
    }
}
