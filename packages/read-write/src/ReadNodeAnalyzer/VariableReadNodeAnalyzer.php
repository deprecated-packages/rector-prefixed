<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\ReadWrite\ReadNodeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\Rector\ReadWrite\Contract\ReadNodeAnalyzerInterface;
final class VariableReadNodeAnalyzer extends \_PhpScoperb75b35f52b74\Rector\ReadWrite\ReadNodeAnalyzer\AbstractReadNodeAnalyzer implements \_PhpScoperb75b35f52b74\Rector\ReadWrite\Contract\ReadNodeAnalyzerInterface
{
    public function supports(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        return $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
    }
    /**
     * @param Variable $node
     */
    public function isRead(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
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
