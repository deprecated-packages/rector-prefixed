<?php

declare (strict_types=1);
namespace Symplify\RuleDocGenerator\Contract;

use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
interface DocumentedRuleInterface
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
}
