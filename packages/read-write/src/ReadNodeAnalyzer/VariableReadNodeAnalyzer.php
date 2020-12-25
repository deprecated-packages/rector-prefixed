<?php

declare (strict_types=1);
namespace Rector\ReadWrite\ReadNodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use Rector\ReadWrite\Contract\ReadNodeAnalyzerInterface;
final class VariableReadNodeAnalyzer extends \Rector\ReadWrite\ReadNodeAnalyzer\AbstractReadNodeAnalyzer implements \Rector\ReadWrite\Contract\ReadNodeAnalyzerInterface
{
    public function supports(\PhpParser\Node $node) : bool
    {
        return $node instanceof \PhpParser\Node\Expr\Variable;
    }
    /**
     * @param Variable $node
     */
    public function isRead(\PhpParser\Node $node) : bool
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
