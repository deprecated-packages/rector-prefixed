<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Naming\Matcher;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
final class VariableAndCallAssignMatcher extends \_PhpScoper2a4e7ab1ecbc\Rector\Naming\Matcher\AbstractMatcher
{
    /**
     * @param Assign $node
     */
    public function getVariableName(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?string
    {
        if (!$node->var instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable) {
            return null;
        }
        return $this->nodeNameResolver->getName($node->var);
    }
    /**
     * @param Assign $node
     */
    public function getVariable(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable
    {
        /** @var Variable $variable */
        $variable = $node->var;
        return $variable;
    }
}
