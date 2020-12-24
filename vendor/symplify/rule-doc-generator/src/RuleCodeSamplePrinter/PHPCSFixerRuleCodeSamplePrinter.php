<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\RuleDocGenerator\RuleCodeSamplePrinter;

use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\DiffCodeSamplePrinter;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class PHPCSFixerRuleCodeSamplePrinter implements \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface
{
    /**
     * @var DiffCodeSamplePrinter
     */
    private $diffCodeSamplePrinter;
    /**
     * @var ConfiguredCodeSamplerPrinter
     */
    private $configuredCodeSamplerPrinter;
    public function __construct(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\DiffCodeSamplePrinter $diffCodeSamplePrinter, \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\RuleCodeSamplePrinter\ConfiguredCodeSamplerPrinter $configuredCodeSamplerPrinter)
    {
        $this->diffCodeSamplePrinter = $diffCodeSamplePrinter;
        $this->configuredCodeSamplerPrinter = $configuredCodeSamplerPrinter;
    }
    public function isMatch(string $class) : bool
    {
        /** @noRector */
        return \is_a($class, '_PhpScopere8e811afab72\\PhpCsFixer\\Fixer\\FixerInterface', \true);
    }
    /**
     * @return mixed[]|string[]
     */
    public function print(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\CodeSampleInterface $codeSample, \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : array
    {
        if ($codeSample instanceof \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample) {
            return $this->configuredCodeSamplerPrinter->printConfiguredCodeSample($ruleDefinition, $codeSample);
        }
        return $this->diffCodeSamplePrinter->print($codeSample);
    }
}
