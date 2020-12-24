<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Parser;

use _PhpScoper0a6b37af0871\PhpParser\Lexer;
use _PhpScoper0a6b37af0871\PHPStan\Php\PhpVersion;
class LexerFactory
{
    /** @var PhpVersion */
    private $phpVersion;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }
    public function create() : \_PhpScoper0a6b37af0871\PhpParser\Lexer
    {
        $options = ['usedAttributes' => ['comments', 'startLine', 'endLine', 'startTokenPos', 'endTokenPos']];
        if ($this->phpVersion->getVersionId() === \PHP_VERSION_ID) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Lexer($options);
        }
        $options['phpVersion'] = $this->phpVersion->getVersionString();
        return new \_PhpScoper0a6b37af0871\PhpParser\Lexer\Emulative($options);
    }
}
