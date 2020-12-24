<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\Rector\Plus;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Div as AssignDiv;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Minus as AssignMinus;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Mul as AssignMul;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Plus as AssignPlus;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Div;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Minus;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Mul;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Plus;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\UnaryMinus;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/I0BGs
 *
 * @see \Rector\DeadCode\Tests\Rector\Plus\RemoveDeadZeroAndOneOperationRector\RemoveDeadZeroAndOneOperationRectorTest
 */
final class RemoveDeadZeroAndOneOperationRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove operation with 1 and 0, that have no effect on the value', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $value = 5 * 1;
        $value = 5 + 0;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $value = 5;
        $value = 5;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Plus::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Minus::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Mul::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Div::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Plus::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Minus::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Mul::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Div::class];
    }
    /**
     * @param Plus|Minus|Mul|Div|AssignPlus|AssignMinus|AssignMul|AssignDiv $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $changedNode = null;
        $previousNode = $node;
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp) {
            $changedNode = $this->processAssignOp($node);
        }
        // -, +
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp) {
            $changedNode = $this->processBinaryOp($node);
        }
        // recurse nested combinations
        while ($changedNode !== null && !$this->areNodesEqual($previousNode, $changedNode)) {
            $previousNode = $changedNode;
            if ($changedNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp || $changedNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp) {
                $changedNode = $this->refactor($changedNode);
            }
            // nothing more to change, return last node
            if ($changedNode === null) {
                return $previousNode;
            }
        }
        return $changedNode;
    }
    private function processAssignOp(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        // +=, -=
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Plus || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Minus) {
            if (!$this->isValue($node->expr, 0)) {
                return null;
            }
            if ($this->isNumberType($node->var)) {
                return $node->var;
            }
        }
        // *, /
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Mul || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Div) {
            if (!$this->isValue($node->expr, 1)) {
                return null;
            }
            if ($this->isNumberType($node->var)) {
                return $node->var;
            }
        }
        return null;
    }
    private function processBinaryOp(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Plus || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Minus) {
            return $this->processBinaryPlusAndMinus($node);
        }
        // *, /
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Mul || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Div) {
            return $this->processBinaryMulAndDiv($node);
        }
        return null;
    }
    /**
     * @param Plus|Minus $binaryOp
     */
    private function processBinaryPlusAndMinus(\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if ($this->isValue($binaryOp->left, 0) && $this->isNumberType($binaryOp->right)) {
            if ($binaryOp instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Minus) {
                return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\UnaryMinus($binaryOp->right);
            }
            return $binaryOp->right;
        }
        if ($this->isValue($binaryOp->right, 0) && $this->isNumberType($binaryOp->left)) {
            return $binaryOp->left;
        }
        return null;
    }
    /**
     * @param Mul|Div $binaryOp
     */
    private function processBinaryMulAndDiv(\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if ($binaryOp instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Mul && $this->isValue($binaryOp->left, 1) && $this->isNumberType($binaryOp->right)) {
            return $binaryOp->right;
        }
        if ($this->isValue($binaryOp->right, 1) && $this->isNumberType($binaryOp->left)) {
            return $binaryOp->left;
        }
        return null;
    }
}
