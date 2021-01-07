<?php

declare (strict_types=1);
namespace Symplify\RuleDocGenerator\RuleCodeSamplePrinter;

use RectorPrefix20210107\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter;
use Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\DiffCodeSamplePrinter;
use Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
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
    public function __construct(\RectorPrefix20210107\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter $smartPhpConfigPrinter, \Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper $markdownCodeWrapper, \Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\DiffCodeSamplePrinter $diffCodeSamplePrinter)
    {
        $this->smartPhpConfigPrinter = $smartPhpConfigPrinter;
        $this->markdownCodeWrapper = $markdownCodeWrapper;
        $this->diffCodeSamplePrinter = $diffCodeSamplePrinter;
    }
    /**
     * @return string[]
     */
    public function printConfiguredCodeSample(\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition, \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample $configuredCodeSample) : array
    {
        $lines = [];
        $configPhpCode = $this->smartPhpConfigPrinter->printConfiguredServices([$ruleDefinition->getRuleClass() => $configuredCodeSample->getConfiguration()]);
        $lines[] = $this->markdownCodeWrapper->printPhpCode($configPhpCode);
        $lines[] = '↓';
        $newLines = $this->diffCodeSamplePrinter->print($configuredCodeSample);
        return \array_merge($lines, $newLines);
    }
}
