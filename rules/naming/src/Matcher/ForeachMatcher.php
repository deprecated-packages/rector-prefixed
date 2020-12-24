<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Matcher;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_;
final class ForeachMatcher extends \_PhpScoperb75b35f52b74\Rector\Naming\Matcher\AbstractMatcher
{
    /**
     * @param Foreach_ $node
     */
    public function getVariableName(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
    {
        if (!$node->valueVar instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            return null;
        }
        return $this->nodeNameResolver->getName($node->valueVar);
    }
    /**
     * @param Foreach_ $node
     */
    public function getVariable(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable
    {
        /** @var Variable $variable */
        $variable = $node->valueVar;
        return $variable;
    }
}
