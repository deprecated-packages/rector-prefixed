<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\RuleDocGenerator\RuleCodeSamplePrinter;

use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\DiffCodeSamplePrinter;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ComposerJsonAwareCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ExtraFileCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class RectorRuleCodeSamplePrinter implements \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface
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
    public function __construct(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\DiffCodeSamplePrinter $diffCodeSamplePrinter, \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper $markdownCodeWrapper, \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\RuleCodeSamplePrinter\ConfiguredCodeSamplerPrinter $configuredCodeSamplerPrinter)
    {
        $this->diffCodeSamplePrinter = $diffCodeSamplePrinter;
        $this->markdownCodeWrapper = $markdownCodeWrapper;
        $this->configuredCodeSamplerPrinter = $configuredCodeSamplerPrinter;
    }
    public function isMatch(string $class) : bool
    {
        /** @noRector */
        return \is_a($class, '_PhpScopere8e811afab72\\Rector\\Core\\Contract\\Rector\\RectorInterface', \true);
    }
    /**
     * @return string[]
     */
    public function print(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\CodeSampleInterface $codeSample, \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : array
    {
        if ($codeSample instanceof \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ExtraFileCodeSample) {
            return $this->printExtraFileCodeSample($codeSample);
        }
        if ($codeSample instanceof \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ComposerJsonAwareCodeSample) {
            return $this->printComposerJsonAwareCodeSample($codeSample);
        }
        if ($codeSample instanceof \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample) {
            return $this->configuredCodeSamplerPrinter->printConfiguredCodeSample($ruleDefinition, $codeSample);
        }
        return $this->diffCodeSamplePrinter->print($codeSample);
    }
    /**
     * @return string[]
     */
    private function printComposerJsonAwareCodeSample(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ComposerJsonAwareCodeSample $composerJsonAwareCodeSample) : array
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
    private function printExtraFileCodeSample(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ExtraFileCodeSample $extraFileCodeSample) : array
    {
        $lines = $this->diffCodeSamplePrinter->print($extraFileCodeSample);
        $lines[] = 'Extra file:';
        $lines[] = $this->markdownCodeWrapper->printPhpCode($extraFileCodeSample->getExtraFile());
        return $lines;
    }
}
