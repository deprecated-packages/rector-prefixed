<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\RuleDocGenerator\RuleCodeSamplePrinter;

use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\BadGoodCodeSamplePrinter;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class PHPCodeSnifferRuleCodeSamplePrinter implements \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface
{
    /**
     * @var BadGoodCodeSamplePrinter
     */
    private $badGoodCodeSamplePrinter;
    public function __construct(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\BadGoodCodeSamplePrinter $badGoodCodeSamplePrinter)
    {
        $this->badGoodCodeSamplePrinter = $badGoodCodeSamplePrinter;
    }
    public function isMatch(string $class) : bool
    {
        /** @noRector */
        return \is_a($class, '_PhpScopere8e811afab72\\PHP_CodeSniffer\\Sniffs\\Sniff', \true);
    }
    /**
     * @return string[]
     */
    public function print(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\CodeSampleInterface $codeSample, \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : array
    {
        return $this->badGoodCodeSamplePrinter->print($codeSample);
    }
}
