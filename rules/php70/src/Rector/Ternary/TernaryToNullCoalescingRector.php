<?php

declare (strict_types=1);
namespace Rector\Php70\Rector\Ternary;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\Coalesce;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\Isset_;
use PhpParser\Node\Expr\Ternary;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\PhpVersionFeature;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Php70\Tests\Rector\Ternary\TernaryToNullCoalescingRector\TernaryToNullCoalescingRectorTest
 */
final class TernaryToNullCoalescingRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes unneeded null check to ?? operator', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$value === null ? 10 : $value;', '$value ?? 10;'), new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('isset($value) ? $value : 10;', '$value ?? 10;')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\Ternary::class];
    }
    /**
     * @param Ternary $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::NULL_COALESCE)) {
            return null;
        }
        if ($node->cond instanceof \PhpParser\Node\Expr\Isset_) {
            return $this->processTernaryWithIsset($node);
        }
        if ($node->cond instanceof \PhpParser\Node\Expr\BinaryOp\Identical) {
            $checkedNode = $node->else;
            $fallbackNode = $node->if;
        } elseif ($node->cond instanceof \PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            $checkedNode = $node->if;
            $fallbackNode = $node->else;
        } else {
            // not a match
            return null;
        }
        if ($checkedNode === null) {
            return null;
        }
        if (!$fallbackNode instanceof \PhpParser\Node\Expr) {
            return null;
        }
        /** @var Identical|NotIdentical $ternaryCompareNode */
        $ternaryCompareNode = $node->cond;
        if ($this->isNullMatch($ternaryCompareNode->left, $ternaryCompareNode->right, $checkedNode)) {
            return new \PhpParser\Node\Expr\BinaryOp\Coalesce($checkedNode, $fallbackNode);
        }
        if ($this->isNullMatch($ternaryCompareNode->right, $ternaryCompareNode->left, $checkedNode)) {
            return new \PhpParser\Node\Expr\BinaryOp\Coalesce($checkedNode, $fallbackNode);
        }
        return null;
    }
    private function processTernaryWithIsset(\PhpParser\Node\Expr\Ternary $ternary) : ?\PhpParser\Node\Expr\BinaryOp\Coalesce
    {
        if ($ternary->if === null) {
            return null;
        }
        /** @var Isset_ $issetNode */
        $issetNode = $ternary->cond;
        // none or multiple isset values cannot be handled here
        if (!isset($issetNode->vars[0])) {
            return null;
        }
        if (\count($issetNode->vars) > 1) {
            return null;
        }
        if ($this->nodeComparator->areNodesEqual($ternary->if, $issetNode->vars[0])) {
            return new \PhpParser\Node\Expr\BinaryOp\Coalesce($ternary->if, $ternary->else);
        }
        return null;
    }
    private function isNullMatch(\PhpParser\Node\Expr $possibleNullExpr, \PhpParser\Node $firstNode, \PhpParser\Node $secondNode) : bool
    {
        if (!$this->valueResolver->isNull($possibleNullExpr)) {
            return \false;
        }
        return $this->nodeComparator->areNodesEqual($firstNode, $secondNode);
    }
}
