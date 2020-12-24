<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php70\Rector\Ternary;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Coalesce;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Isset_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Php70\Tests\Rector\Ternary\TernaryToNullCoalescingRector\TernaryToNullCoalescingRectorTest
 */
final class TernaryToNullCoalescingRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes unneeded null check to ?? operator', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$value === null ? 10 : $value;', '$value ?? 10;'), new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('isset($value) ? $value : 10;', '$value ?? 10;')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary::class];
    }
    /**
     * @param Ternary $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature::NULL_COALESCE)) {
            return null;
        }
        if ($node->cond instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Isset_) {
            return $this->processTernaryWithIsset($node);
        }
        if ($node->cond instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical) {
            $checkedNode = $node->else;
            $fallbackNode = $node->if;
        } elseif ($node->cond instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            $checkedNode = $node->if;
            $fallbackNode = $node->else;
        } else {
            // not a match
            return null;
        }
        if ($checkedNode === null || $fallbackNode === null) {
            return null;
        }
        /** @var Identical|NotIdentical $ternaryCompareNode */
        $ternaryCompareNode = $node->cond;
        if ($this->isNullMatch($ternaryCompareNode->left, $ternaryCompareNode->right, $checkedNode) || $this->isNullMatch($ternaryCompareNode->right, $ternaryCompareNode->left, $checkedNode)) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Coalesce($checkedNode, $fallbackNode);
        }
        return null;
    }
    private function processTernaryWithIsset(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary $ternary) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Coalesce
    {
        if ($ternary->if === null) {
            return null;
        }
        /** @var Isset_ $issetNode */
        $issetNode = $ternary->cond;
        // none or multiple isset values cannot be handled here
        if (!isset($issetNode->vars[0]) || \count($issetNode->vars) > 1) {
            return null;
        }
        if ($this->areNodesEqual($ternary->if, $issetNode->vars[0])) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Coalesce($ternary->if, $ternary->else);
        }
        return null;
    }
    private function isNullMatch(\_PhpScoper0a6b37af0871\PhpParser\Node $possibleNullNode, \_PhpScoper0a6b37af0871\PhpParser\Node $firstNode, \_PhpScoper0a6b37af0871\PhpParser\Node $secondNode) : bool
    {
        if (!$this->isNull($possibleNullNode)) {
            return \false;
        }
        return $this->areNodesEqual($firstNode, $secondNode);
    }
}
