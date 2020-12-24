<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\Contract;

use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
interface DocumentedRuleInterface
{
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
}
