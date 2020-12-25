<?php

declare (strict_types=1);
namespace PHPStan\Parser;

use PhpParser\Lexer;
use PHPStan\Php\PhpVersion;
class LexerFactory
{
    /** @var PhpVersion */
    private $phpVersion;
    public function __construct(\PHPStan\Php\PhpVersion $phpVersion)
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
