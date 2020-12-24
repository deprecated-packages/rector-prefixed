<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\ReadWrite\ReadNodeAnalyzer;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\Rector\ReadWrite\Contract\ReadNodeAnalyzerInterface;
final class VariableReadNodeAnalyzer extends \_PhpScoper0a6b37af0871\Rector\ReadWrite\ReadNodeAnalyzer\AbstractReadNodeAnalyzer implements \_PhpScoper0a6b37af0871\Rector\ReadWrite\Contract\ReadNodeAnalyzerInterface
{
    public function supports(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        return $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
    }
    /**
     * @param Variable $node
     */
    public function isRead(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        $parentScope = $this->parentScopeFinder->find($node);
        if ($parentScope === null) {
            return \false;
        }
        $variableUsages = $this->nodeUsageFinder->findVariableUsages((array) $parentScope->stmts, $node);
        foreach ($variableUsages as $variableUsage) {
            if ($this->isCurrentContextRead($variableUsage)) {
                return \true;
            }
        }
        return \false;
    }
}
