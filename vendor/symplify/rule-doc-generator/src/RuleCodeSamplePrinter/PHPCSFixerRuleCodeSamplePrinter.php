<?php

declare (strict_types=1);
namespace RectorPrefix20201228\Symplify\RuleDocGenerator\RuleCodeSamplePrinter;

use RectorPrefix20201228\Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
use RectorPrefix20201228\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface;
use RectorPrefix20201228\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\DiffCodeSamplePrinter;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class PHPCSFixerRuleCodeSamplePrinter implements \RectorPrefix20201228\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface
{
    /**
     * @var DiffCodeSamplePrinter
     */
    private $diffCodeSamplePrinter;
    /**
     * @var ConfiguredCodeSamplerPrinter
     */
    private $configuredCodeSamplerPrinter;
    public function __construct(\RectorPrefix20201228\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\DiffCodeSamplePrinter $diffCodeSamplePrinter, \RectorPrefix20201228\Symplify\RuleDocGenerator\RuleCodeSamplePrinter\ConfiguredCodeSamplerPrinter $configuredCodeSamplerPrinter)
    {
        $this->diffCodeSamplePrinter = $diffCodeSamplePrinter;
        $this->configuredCodeSamplerPrinter = $configuredCodeSamplerPrinter;
    }
    public function isMatch(string $class) : bool
    {
        /** @noRector */
        return \is_a($class, 'RectorPrefix20201228\\PhpCsFixer\\Fixer\\FixerInterface', \true);
    }
    /**
     * @return mixed[]|string[]
     */
    public function print(\RectorPrefix20201228\Symplify\RuleDocGenerator\Contract\CodeSampleInterface $codeSample, \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : array
    {
        if ($codeSample instanceof \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample) {
            return $this->configuredCodeSamplerPrinter->printConfiguredCodeSample($ruleDefinition, $codeSample);
        }
        return $this->diffCodeSamplePrinter->print($codeSample);
    }
}
