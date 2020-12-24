<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Matcher;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_;
final class ForeachMatcher extends \_PhpScopere8e811afab72\Rector\Naming\Matcher\AbstractMatcher
{
    /**
     * @param Foreach_ $node
     */
    public function getVariableName(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string
    {
        if (!$node->valueVar instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return null;
        }
        return $this->nodeNameResolver->getName($node->valueVar);
    }
    /**
     * @param Foreach_ $node
     */
    public function getVariable(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable
    {
        /** @var Variable $variable */
        $variable = $node->valueVar;
        return $variable;
    }
}
