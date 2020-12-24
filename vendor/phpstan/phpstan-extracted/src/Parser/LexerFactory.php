<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Parser;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Lexer;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Php\PhpVersion;
class LexerFactory
{
    /** @var PhpVersion */
    private $phpVersion;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }
    public function create() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Lexer
    {
        $options = ['usedAttributes' => ['comments', 'startLine', 'endLine', 'startTokenPos', 'endTokenPos']];
        if ($this->phpVersion->getVersionId() === \PHP_VERSION_ID) {
            return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Lexer($options);
        }
        $options['phpVersion'] = $this->phpVersion->getVersionString();
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Lexer\Emulative($options);
    }
}
