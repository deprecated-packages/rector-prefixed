<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Matcher;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
final class VariableAndCallAssignMatcher extends \_PhpScoperb75b35f52b74\Rector\Naming\Matcher\AbstractMatcher
{
    /**
     * @param Assign $node
     */
    public function getVariableName(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
    {
        if (!$node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            return null;
        }
        return $this->nodeNameResolver->getName($node->var);
    }
    /**
     * @param Assign $node
     */
    public function getVariable(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable
    {
        /** @var Variable $variable */
        $variable = $node->var;
        return $variable;
    }
}
