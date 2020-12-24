<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\RuleDocGenerator\RuleCodeSamplePrinter;

use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\DiffCodeSamplePrinter;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
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
    public function __construct(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter $smartPhpConfigPrinter, \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper $markdownCodeWrapper, \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\DiffCodeSamplePrinter $diffCodeSamplePrinter)
    {
        $this->smartPhpConfigPrinter = $smartPhpConfigPrinter;
        $this->markdownCodeWrapper = $markdownCodeWrapper;
        $this->diffCodeSamplePrinter = $diffCodeSamplePrinter;
    }
    /**
     * @return string[]
     */
    public function printConfiguredCodeSample(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition, \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample $configuredCodeSample) : array
    {
        $lines = [];
        $configPhpCode = $this->smartPhpConfigPrinter->printConfiguredServices([$ruleDefinition->getRuleClass() => $configuredCodeSample->getConfiguration()]);
        $lines[] = $this->markdownCodeWrapper->printPhpCode($configPhpCode);
        $lines[] = '↓';
        $newLines = $this->diffCodeSamplePrinter->print($configuredCodeSample);
        return \array_merge($lines, $newLines);
    }
}
