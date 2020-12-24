<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\RuleCodeSamplePrinter;

use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\DiffCodeSamplePrinter;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ComposerJsonAwareCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ExtraFileCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class RectorRuleCodeSamplePrinter implements \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface
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
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\DiffCodeSamplePrinter $diffCodeSamplePrinter, \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper $markdownCodeWrapper, \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\RuleCodeSamplePrinter\ConfiguredCodeSamplerPrinter $configuredCodeSamplerPrinter)
    {
        $this->diffCodeSamplePrinter = $diffCodeSamplePrinter;
        $this->markdownCodeWrapper = $markdownCodeWrapper;
        $this->configuredCodeSamplerPrinter = $configuredCodeSamplerPrinter;
    }
    public function isMatch(string $class) : bool
    {
        /** @noRector */
        return \is_a($class, '_PhpScoperb75b35f52b74\\Rector\\Core\\Contract\\Rector\\RectorInterface', \true);
    }
    /**
     * @return string[]
     */
    public function print(\_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Contract\CodeSampleInterface $codeSample, \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : array
    {
        if ($codeSample instanceof \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ExtraFileCodeSample) {
            return $this->printExtraFileCodeSample($codeSample);
        }
        if ($codeSample instanceof \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ComposerJsonAwareCodeSample) {
            return $this->printComposerJsonAwareCodeSample($codeSample);
        }
        if ($codeSample instanceof \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample) {
            return $this->configuredCodeSamplerPrinter->printConfiguredCodeSample($ruleDefinition, $codeSample);
        }
        return $this->diffCodeSamplePrinter->print($codeSample);
    }
    /**
     * @return string[]
     */
    private function printComposerJsonAwareCodeSample(\_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ComposerJsonAwareCodeSample $composerJsonAwareCodeSample) : array
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
    private function printExtraFileCodeSample(\_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ExtraFileCodeSample $extraFileCodeSample) : array
    {
        $lines = $this->diffCodeSamplePrinter->print($extraFileCodeSample);
        $lines[] = 'Extra file:';
        $lines[] = $this->markdownCodeWrapper->printPhpCode($extraFileCodeSample->getExtraFile());
        return $lines;
    }
}
