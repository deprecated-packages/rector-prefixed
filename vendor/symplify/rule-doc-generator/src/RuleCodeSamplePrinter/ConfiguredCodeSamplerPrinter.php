<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\RuleCodeSamplePrinter;

use _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\DiffCodeSamplePrinter;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
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
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter $smartPhpConfigPrinter, \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper $markdownCodeWrapper, \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\DiffCodeSamplePrinter $diffCodeSamplePrinter)
    {
        $this->smartPhpConfigPrinter = $smartPhpConfigPrinter;
        $this->markdownCodeWrapper = $markdownCodeWrapper;
        $this->diffCodeSamplePrinter = $diffCodeSamplePrinter;
    }
    /**
     * @return string[]
     */
    public function printConfiguredCodeSample(\_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition, \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample $configuredCodeSample) : array
    {
        $lines = [];
        $configPhpCode = $this->smartPhpConfigPrinter->printConfiguredServices([$ruleDefinition->getRuleClass() => $configuredCodeSample->getConfiguration()]);
        $lines[] = $this->markdownCodeWrapper->printPhpCode($configPhpCode);
        $lines[] = '↓';
        $newLines = $this->diffCodeSamplePrinter->print($configuredCodeSample);
        return \array_merge($lines, $newLines);
    }
}
