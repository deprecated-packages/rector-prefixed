<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Parser;

use _PhpScoperb75b35f52b74\PhpParser\Lexer;
use _PhpScoperb75b35f52b74\PHPStan\Php\PhpVersion;
class LexerFactory
{
    /** @var PhpVersion */
    private $phpVersion;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }
    public function create() : \_PhpScoperb75b35f52b74\PhpParser\Lexer
    {
        $options = ['usedAttributes' => ['comments', 'startLine', 'endLine', 'startTokenPos', 'endTokenPos']];
        if ($this->phpVersion->getVersionId() === \PHP_VERSION_ID) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Lexer($options);
        }
        $options['phpVersion'] = $this->phpVersion->getVersionString();
        return new \_PhpScoperb75b35f52b74\PhpParser\Lexer\Emulative($options);
    }
}
