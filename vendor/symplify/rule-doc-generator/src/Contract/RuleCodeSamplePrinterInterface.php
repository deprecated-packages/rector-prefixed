<?php

declare (strict_types=1);
namespace RectorPrefix20201227\Symplify\RuleDocGenerator\Contract;

use RectorPrefix20201227\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
interface RuleCodeSamplePrinterInterface
{
    public function isMatch(string $class) : bool;
    /**
     * @return string[]
     */
    public function print(\RectorPrefix20201227\Symplify\RuleDocGenerator\Contract\CodeSampleInterface $codeSample, \RectorPrefix20201227\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : array;
}
