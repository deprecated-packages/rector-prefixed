<?php

declare (strict_types=1);
namespace Rector\Php70\Rector\Assign;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\List_;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\PhpVersionFeature;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @source http://php.net/manual/en/migration70.incompatible.php#migration70.incompatible.variable-handling.list
 * @see \Rector\Php70\Tests\Rector\Assign\ListSwapArrayOrderRector\ListSwapArrayOrderRectorTest
 */
final class ListSwapArrayOrderRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('list() assigns variables in reverse order - relevant in array assign', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('list($a[], $a[]) = [1, 2];', 'list($a[], $a[]) = array_reverse([1, 2]);')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::LIST_SWAP_ORDER)) {
            return null;
        }
        if (!$node->var instanceof \PhpParser\Node\Expr\List_) {
            return null;
        }
        $printedVariables = [];
        foreach ($node->var->items as $arrayItem) {
            if (!$arrayItem instanceof \PhpParser\Node\Expr\ArrayItem) {
                continue;
            }
            if ($arrayItem->value instanceof \PhpParser\Node\Expr\ArrayDimFetch && $arrayItem->value->dim === null) {
                $printedVariables[] = $this->print($arrayItem->value->var);
            } else {
                return null;
            }
        }
        // relevant only in 1 variable type
        $uniqueVariables = \array_unique($printedVariables);
        if (\count($uniqueVariables) !== 1) {
            return null;
        }
        // wrap with array_reverse, to reflect reverse assign order in left
        $node->expr = $this->nodeFactory->createFuncCall('array_reverse', [$node->expr]);
        return $node;
    }
}
