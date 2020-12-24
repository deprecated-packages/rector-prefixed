<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract;

use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
interface RuleCodeSamplePrinterInterface
{
    public function isMatch(string $class) : bool;
    /**
     * @return string[]
     */
    public function print(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\CodeSampleInterface $codeSample, \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : array;
}
