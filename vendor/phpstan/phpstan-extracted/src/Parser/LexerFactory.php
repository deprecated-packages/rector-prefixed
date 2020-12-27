<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Parser;

use PhpParser\Lexer;
use RectorPrefix20201227\PHPStan\Php\PhpVersion;
class LexerFactory
{
    /** @var PhpVersion */
    private $phpVersion;
    public function __construct(\RectorPrefix20201227\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }
    public function create() : \PhpParser\Lexer
    {
        $options = ['usedAttributes' => ['comments', 'startLine', 'endLine', 'startTokenPos', 'endTokenPos']];
        if ($this->phpVersion->getVersionId() === \PHP_VERSION_ID) {
            return new \PhpParser\Lexer($options);
        }
        $options['phpVersion'] = $this->phpVersion->getVersionString();
        return new \PhpParser\Lexer\Emulative($options);
    }
}
