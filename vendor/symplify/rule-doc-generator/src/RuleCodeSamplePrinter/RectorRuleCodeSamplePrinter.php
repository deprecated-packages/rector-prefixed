<?php

declare (strict_types=1);
namespace RectorPrefix20201228\Symplify\RuleDocGenerator\RuleCodeSamplePrinter;

use RectorPrefix20201228\Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
use RectorPrefix20201228\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface;
use RectorPrefix20201228\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\DiffCodeSamplePrinter;
use RectorPrefix20201228\Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\ComposerJsonAwareCodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\ExtraFileCodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class RectorRuleCodeSamplePrinter implements \RectorPrefix20201228\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface
{
    /**
     * @var DiffCodeSamplePrinter
     */
    private $diffCodeSamplePrinter;
    /**
     * @var MarkdownCodeWrapper
     */
    private $markdownCodeWrapper;
    /**
     * @var ConfiguredCodeSamplerPrinter
     */
    private $configuredCodeSamplerPrinter;
    public function __construct(\RectorPrefix20201228\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\DiffCodeSamplePrinter $diffCodeSamplePrinter, \RectorPrefix20201228\Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper $markdownCodeWrapper, \RectorPrefix20201228\Symplify\RuleDocGenerator\RuleCodeSamplePrinter\ConfiguredCodeSamplerPrinter $configuredCodeSamplerPrinter)
    {
        $this->diffCodeSamplePrinter = $diffCodeSamplePrinter;
        $this->markdownCodeWrapper = $markdownCodeWrapper;
        $this->configuredCodeSamplerPrinter = $configuredCodeSamplerPrinter;
    }
    public function isMatch(string $class) : bool
    {
        /** @noRector */
        return \is_a($class, 'Rector\\Core\\Contract\\Rector\\RectorInterface', \true);
    }
    /**
     * @return string[]
     */
    public function print(\RectorPrefix20201228\Symplify\RuleDocGenerator\Contract\CodeSampleInterface $codeSample, \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : array
    {
        if ($codeSample instanceof \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\ExtraFileCodeSample) {
            return $this->printExtraFileCodeSample($codeSample);
        }
        if ($codeSample instanceof \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\ComposerJsonAwareCodeSample) {
            return $this->printComposerJsonAwareCodeSample($codeSample);
        }
        if ($codeSample instanceof \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample) {
            return $this->configuredCodeSamplerPrinter->printConfiguredCodeSample($ruleDefinition, $codeSample);
        }
        return $this->diffCodeSamplePrinter->print($codeSample);
    }
    /**
     * @return string[]
     */
    private function printComposerJsonAwareCodeSample(\RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\ComposerJsonAwareCodeSample $composerJsonAwareCodeSample) : array
    {
        $lines = [];
        $lines[] = '- with `composer.json`:';
        $lines[] = $this->markdownCodeWrapper->printJsonCode($composerJsonAwareCodeSample->getComposerJson());
        $lines[] = '↓';
        $newLines = $this->diffCodeSamplePrinter->print($composerJsonAwareCodeSample);
        return \array_merge($lines, $newLines);
    }
    /**
     * @return string[]
     */
    private function printExtraFileCodeSample(\RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\ExtraFileCodeSample $extraFileCodeSample) : array
    {
        $lines = $this->diffCodeSamplePrinter->print($extraFileCodeSample);
        $lines[] = 'Extra file:';
        $lines[] = $this->markdownCodeWrapper->printPhpCode($extraFileCodeSample->getExtraFile());
        return $lines;
    }
}
