<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\Contract\Category;

use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
interface CategoryInfererInterface
{
    public function infer(\_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : ?string;
}
