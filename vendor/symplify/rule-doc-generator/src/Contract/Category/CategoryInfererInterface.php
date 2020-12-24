<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\Category;

use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
interface CategoryInfererInterface
{
    public function infer(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : ?string;
}
