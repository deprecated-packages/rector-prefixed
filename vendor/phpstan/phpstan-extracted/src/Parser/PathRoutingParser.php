<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Parser;

use _PhpScoper0a2ac50786fa\PHPStan\File\FileHelper;
class PathRoutingParser implements \_PhpScoper0a2ac50786fa\PHPStan\Parser\Parser
{
    /** @var FileHelper */
    private $fileHelper;
    /** @var Parser */
    private $currentPhpVersionRichParser;
    /** @var Parser */
    private $currentPhpVersionSimpleParser;
    /** @var Parser */
    private $php8Parser;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\File\FileHelper $fileHelper, \_PhpScoper0a2ac50786fa\PHPStan\Parser\Parser $currentPhpVersionRichParser, \_PhpScoper0a2ac50786fa\PHPStan\Parser\Parser $currentPhpVersionSimpleParser, \_PhpScoper0a2ac50786fa\PHPStan\Parser\Parser $php8Parser)
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
