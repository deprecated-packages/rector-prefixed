<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Parser;

use _PhpScoper0a2ac50786fa\PhpParser\Lexer;
use _PhpScoper0a2ac50786fa\PHPStan\Php\PhpVersion;
class LexerFactory
{
    /** @var PhpVersion */
    private $phpVersion;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }
    public function create() : \_PhpScoper0a2ac50786fa\PhpParser\Lexer
    {
        $options = ['usedAttributes' => ['comments', 'startLine', 'endLine', 'startTokenPos', 'endTokenPos']];
        if ($this->phpVersion->getVersionId() === \PHP_VERSION_ID) {
            return new \_PhpScoper0a2ac50786fa\PhpParser\Lexer($options);
        }
        $options['phpVersion'] = $this->phpVersion->getVersionString();
        return new \_PhpScoper0a2ac50786fa\PhpParser\Lexer\Emulative($options);
    }
}
