<?php

declare (strict_types=1);
namespace RectorPrefix20201227\Symplify\RuleDocGenerator\Contract;

use RectorPrefix20201227\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
interface DocumentedRuleInterface
{
    public function getRuleDefinition() : \RectorPrefix20201227\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
}
