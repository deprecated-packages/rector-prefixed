<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\Matcher;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
final class VariableAndCallAssignMatcher extends \_PhpScoper0a6b37af0871\Rector\Naming\Matcher\AbstractMatcher
{
    /**
     * @param Assign $node
     */
    public function getVariableName(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?string
    {
        if (!$node->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable) {
            return null;
        }
        return $this->nodeNameResolver->getName($node->var);
    }
    /**
     * @param Assign $node
     */
    public function getVariable(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable
    {
        /** @var Variable $variable */
        $variable = $node->var;
        return $variable;
    }
}
