<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\ReadWrite\ReadNodeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\Rector\ReadWrite\Contract\ReadNodeAnalyzerInterface;
final class VariableReadNodeAnalyzer extends \_PhpScopere8e811afab72\Rector\ReadWrite\ReadNodeAnalyzer\AbstractReadNodeAnalyzer implements \_PhpScopere8e811afab72\Rector\ReadWrite\Contract\ReadNodeAnalyzerInterface
{
    public function supports(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
    }
    /**
     * @param Variable $node
     */
    public function isRead(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
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
