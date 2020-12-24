<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Parser;

use _PhpScopere8e811afab72\PhpParser\Lexer;
use _PhpScopere8e811afab72\PHPStan\Php\PhpVersion;
class LexerFactory
{
    /** @var PhpVersion */
    private $phpVersion;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }
    public function create() : \_PhpScopere8e811afab72\PhpParser\Lexer
    {
        $options = ['usedAttributes' => ['comments', 'startLine', 'endLine', 'startTokenPos', 'endTokenPos']];
        if ($this->phpVersion->getVersionId() === \PHP_VERSION_ID) {
            return new \_PhpScopere8e811afab72\PhpParser\Lexer($options);
        }
        $options['phpVersion'] = $this->phpVersion->getVersionString();
        return new \_PhpScopere8e811afab72\PhpParser\Lexer\Emulative($options);
    }
}
