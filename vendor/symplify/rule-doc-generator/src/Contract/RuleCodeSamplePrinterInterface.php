<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Contract;

use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
interface RuleCodeSamplePrinterInterface
{
    public function isMatch(string $class) : bool;
    /**
     * @return string[]
     */
    public function print(\_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Contract\CodeSampleInterface $codeSample, \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : array;
}
