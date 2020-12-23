<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Naming\Matcher;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_;
final class ForeachMatcher extends \_PhpScoper0a2ac50786fa\Rector\Naming\Matcher\AbstractMatcher
{
    /**
     * @param Foreach_ $node
     */
    public function getVariableName(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?string
    {
        if (!$node->valueVar instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
            return null;
        }
        return $this->nodeNameResolver->getName($node->valueVar);
    }
    /**
     * @param Foreach_ $node
     */
    public function getVariable(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable
    {
        /** @var Variable $variable */
        $variable = $node->valueVar;
        return $variable;
    }
}
