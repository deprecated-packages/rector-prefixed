<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\Contract\Category;

use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
interface CategoryInfererInterface
{
    public function infer(\_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : ?string;
}
