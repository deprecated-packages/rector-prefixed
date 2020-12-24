<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\RuleDocGenerator\RuleCodeSamplePrinter;

use _PhpScopere8e811afab72\Symplify\PackageBuilder\Neon\NeonPrinter;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\BadGoodCodeSamplePrinter;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class PHPStanRuleCodeSamplePrinter implements \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface
{
    /**
     * @var NeonPrinter
     */
    private $neonPrinter;
    /**
     * @var MarkdownCodeWrapper
     */
    private $markdownCodeWrapper;
    /**
     * @var BadGoodCodeSamplePrinter
     */
    private $badGoodCodeSamplePrinter;
    public function __construct(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Neon\NeonPrinter $neonPrinter, \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\Printer\MarkdownCodeWrapper $markdownCodeWrapper, \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\BadGoodCodeSamplePrinter $badGoodCodeSamplePrinter)
    {
        $this->neonPrinter = $neonPrinter;
        $this->markdownCodeWrapper = $markdownCodeWrapper;
        $this->badGoodCodeSamplePrinter = $badGoodCodeSamplePrinter;
    }
    public function isMatch(string $class) : bool
    {
        /** @noRector */
        return \is_a($class, '_PhpScopere8e811afab72\\PHPStan\\Rules\\Rule', \true);
    }
    /**
     * @return string[]
     */
    public function print(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\CodeSampleInterface $codeSample, \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : array
    {
        if ($codeSample instanceof \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample) {
            return $this->printConfigurableCodeSample($codeSample, $ruleDefinition);
        }
        return $this->badGoodCodeSamplePrinter->print($codeSample);
    }
    /**
     * @return string[]
     */
    private function printConfigurableCodeSample(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample $configuredCodeSample, \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : array
    {
        $lines = [];
        $phpstanNeon = ['services' => [['class' => $ruleDefinition->getRuleClass(), 'tags' => ['phpstan.rules.rule'], 'arguments' => $configuredCodeSample->getConfiguration()]]];
        $printedNeon = $this->neonPrinter->printNeon($phpstanNeon);
        $lines[] = $this->markdownCodeWrapper->printYamlCode($printedNeon);
        $lines[] = '↓';
        $newLines = $this->badGoodCodeSamplePrinter->print($configuredCodeSample);
        return \array_merge($lines, $newLines);
    }
}
