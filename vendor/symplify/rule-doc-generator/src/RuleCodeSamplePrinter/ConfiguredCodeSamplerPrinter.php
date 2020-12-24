<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\RuleCodeSamplePrinter;

use _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\DiffCodeSamplePrinter;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class ConfiguredCodeSamplerPrinter
{
    /**
     * @var SmartPhpConfigPrinter
     */
    private $smartPhpConfigPrinter;
    /**
     * @var MarkdownCodeWrapper
     */
    private $markdownCodeWrapper;
    /**
     * @var DiffCodeSamplePrinter
     */
    private $diffCodeSamplePrinter;
    public function __construct(\_PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter $smartPhpConfigPrinter, \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper $markdownCodeWrapper, \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\DiffCodeSamplePrinter $diffCodeSamplePrinter)
    {
        $this->smartPhpConfigPrinter = $smartPhpConfigPrinter;
        $this->markdownCodeWrapper = $markdownCodeWrapper;
        $this->diffCodeSamplePrinter = $diffCodeSamplePrinter;
    }
    /**
     * @return string[]
     */
    public function printConfiguredCodeSample(\_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition, \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample $configuredCodeSample) : array
    {
        $lines = [];
        $configPhpCode = $this->smartPhpConfigPrinter->printConfiguredServices([$ruleDefinition->getRuleClass() => $configuredCodeSample->getConfiguration()]);
        $lines[] = $this->markdownCodeWrapper->printPhpCode($configPhpCode);
        $lines[] = '↓';
        $newLines = $this->diffCodeSamplePrinter->print($configuredCodeSample);
        return \array_merge($lines, $newLines);
    }
}
