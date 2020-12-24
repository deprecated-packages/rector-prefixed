<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Parser;

use _PhpScopere8e811afab72\PHPStan\File\FileHelper;
class PathRoutingParser implements \_PhpScopere8e811afab72\PHPStan\Parser\Parser
{
    /** @var FileHelper */
    private $fileHelper;
    /** @var Parser */
    private $currentPhpVersionRichParser;
    /** @var Parser */
    private $currentPhpVersionSimpleParser;
    /** @var Parser */
    private $php8Parser;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\File\FileHelper $fileHelper, \_PhpScopere8e811afab72\PHPStan\Parser\Parser $currentPhpVersionRichParser, \_PhpScopere8e811afab72\PHPStan\Parser\Parser $currentPhpVersionSimpleParser, \_PhpScopere8e811afab72\PHPStan\Parser\Parser $php8Parser)
    {
        $this->fileHelper = $fileHelper;
        $this->currentPhpVersionRichParser = $currentPhpVersionRichParser;
        $this->currentPhpVersionSimpleParser = $currentPhpVersionSimpleParser;
        $this->php8Parser = $php8Parser;
    }
    public function parseFile(string $file) : array
    {
        $file = $this->fileHelper->normalizePath($file, '/');
        if (\strpos($file, 'vendor/jetbrains/phpstorm-stubs') !== \false) {
            return $this->php8Parser->parseFile($file);
        }
        return $this->currentPhpVersionRichParser->parseFile($file);
    }
    public function parseString(string $sourceCode) : array
    {
        return $this->currentPhpVersionSimpleParser->parseString($sourceCode);
    }
}
