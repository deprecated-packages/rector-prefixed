<?php

declare (strict_types=1);
namespace RectorPrefix20201228\Symplify\RuleDocGenerator\Contract\Category;

use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
interface CategoryInfererInterface
{
    public function infer(\RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : ?string;
}
