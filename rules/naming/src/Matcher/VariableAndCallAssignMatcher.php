<?php

declare (strict_types=1);
namespace Rector\Naming\Matcher;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Variable;
final class VariableAndCallAssignMatcher extends \Rector\Naming\Matcher\AbstractMatcher
{
    /**
     * @param Assign $node
     */
    public function getVariableName(\PhpParser\Node $node) : ?string
    {
        if (!$node->var instanceof \PhpParser\Node\Expr\Variable) {
            return null;
        }
        return $this->nodeNameResolver->getName($node->var);
    }
    /**
     * @param Assign $node
     */
    public function getVariable(\PhpParser\Node $node) : \PhpParser\Node\Expr\Variable
    {
        /** @var Variable $variable */
        $variable = $node->var;
        return $variable;
    }
}
