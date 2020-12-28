<?php

declare (strict_types=1);
namespace RectorPrefix20201228\Symplify\RuleDocGenerator\RuleCodeSamplePrinter;

use RectorPrefix20201228\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter;
use RectorPrefix20201228\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\DiffCodeSamplePrinter;
use RectorPrefix20201228\Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
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
    public function __construct(\RectorPrefix20201228\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter $smartPhpConfigPrinter, \RectorPrefix20201228\Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper $markdownCodeWrapper, \RectorPrefix20201228\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\DiffCodeSamplePrinter $diffCodeSamplePrinter)
    {
        $this->smartPhpConfigPrinter = $smartPhpConfigPrinter;
        $this->markdownCodeWrapper = $markdownCodeWrapper;
        $this->diffCodeSamplePrinter = $diffCodeSamplePrinter;
    }
    /**
     * @return string[]
     */
    public function printConfiguredCodeSample(\RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition, \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample $configuredCodeSample) : array
    {
        $lines = [];
        $configPhpCode = $this->smartPhpConfigPrinter->printConfiguredServices([$ruleDefinition->getRuleClass() => $configuredCodeSample->getConfiguration()]);
        $lines[] = $this->markdownCodeWrapper->printPhpCode($configPhpCode);
        $lines[] = '↓';
        $newLines = $this->diffCodeSamplePrinter->print($configuredCodeSample);
        return \array_merge($lines, $newLines);
    }
}
