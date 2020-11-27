<?php

declare (strict_types=1);
namespace Rector\Naming\Matcher;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Foreach_;
final class ForeachMatcher extends \Rector\Naming\Matcher\AbstractMatcher
{
    /**
     * @param Foreach_ $node
     */
    public function getVariableName(\PhpParser\Node $node) : ?string
    {
        if (!$node->valueVar instanceof \PhpParser\Node\Expr\Variable) {
            return null;
        }
        return $this->nodeNameResolver->getName($node->valueVar);
    }
    /**
     * @param Foreach_ $node
     */
    public function getVariable(\PhpParser\Node $node) : \PhpParser\Node\Expr\Variable
    {
        /** @var Variable $variable */
        $variable = $node->valueVar;
        return $variable;
    }
}
