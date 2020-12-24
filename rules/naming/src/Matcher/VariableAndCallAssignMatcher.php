<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Matcher;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
final class VariableAndCallAssignMatcher extends \_PhpScopere8e811afab72\Rector\Naming\Matcher\AbstractMatcher
{
    /**
     * @param Assign $node
     */
    public function getVariableName(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string
    {
        if (!$node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return null;
        }
        return $this->nodeNameResolver->getName($node->var);
    }
    /**
     * @param Assign $node
     */
    public function getVariable(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable
    {
        /** @var Variable $variable */
        $variable = $node->var;
        return $variable;
    }
}
