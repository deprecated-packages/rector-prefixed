<?php

declare (strict_types=1);
namespace Rector\DeadCode\Rector\Plus;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\AssignOp;
use PhpParser\Node\Expr\AssignOp\Div as AssignDiv;
use PhpParser\Node\Expr\AssignOp\Minus as AssignMinus;
use PhpParser\Node\Expr\AssignOp\Mul as AssignMul;
use PhpParser\Node\Expr\AssignOp\Plus as AssignPlus;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Expr\BinaryOp\Div;
use PhpParser\Node\Expr\BinaryOp\Minus;
use PhpParser\Node\Expr\BinaryOp\Mul;
use PhpParser\Node\Expr\BinaryOp\Plus;
use PhpParser\Node\Expr\UnaryMinus;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/I0BGs
 *
 * @see \Rector\Tests\DeadCode\Rector\Plus\RemoveDeadZeroAndOneOperationRector\RemoveDeadZeroAndOneOperationRectorTest
 */
final class RemoveDeadZeroAndOneOperationRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove operation with 1 and 0, that have no effect on the value', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\BinaryOp\Plus::class, \PhpParser\Node\Expr\BinaryOp\Minus::class, \PhpParser\Node\Expr\BinaryOp\Mul::class, \PhpParser\Node\Expr\BinaryOp\Div::class, \PhpParser\Node\Expr\AssignOp\Plus::class, \PhpParser\Node\Expr\AssignOp\Minus::class, \PhpParser\Node\Expr\AssignOp\Mul::class, \PhpParser\Node\Expr\AssignOp\Div::class];
    }
    /**
     * @param Plus|Minus|Mul|Div|AssignPlus|AssignMinus|AssignMul|AssignDiv $node
     * @return \PhpParser\Node|null
     */
    public function refactor(\PhpParser\Node $node)
    {
        $changedNode = null;
        $previousNode = $node;
        if ($node instanceof \PhpParser\Node\Expr\AssignOp) {
            $changedNode = $this->processAssignOp($node);
        }
        // -, +
        if ($node instanceof \PhpParser\Node\Expr\BinaryOp) {
            $changedNode = $this->processBinaryOp($node);
        }
        // recurse nested combinations
        while ($changedNode !== null && !$this->nodeComparator->areNodesEqual($previousNode, $changedNode)) {
            $previousNode = $changedNode;
            if ($changedNode instanceof \PhpParser\Node\Expr\BinaryOp || $changedNode instanceof \PhpParser\Node\Expr\AssignOp) {
                $changedNode = $this->refactor($changedNode);
            }
            // nothing more to change, return last node
            if (!$changedNode instanceof \PhpParser\Node) {
                return $previousNode;
            }
        }
        return $changedNode;
    }
    /**
     * @return \PhpParser\Node\Expr|null
     */
    private function processAssignOp(\PhpParser\Node $node)
    {
        // +=, -=
        if ($node instanceof \PhpParser\Node\Expr\AssignOp\Plus || $node instanceof \PhpParser\Node\Expr\AssignOp\Minus) {
            if (!$this->valueResolver->isValue($node->expr, 0)) {
                return null;
            }
            if ($this->nodeTypeResolver->isNumberType($node->var)) {
                return $node->var;
            }
        }
        // *, /
        if ($node instanceof \PhpParser\Node\Expr\AssignOp\Mul || $node instanceof \PhpParser\Node\Expr\AssignOp\Div) {
            if (!$this->valueResolver->isValue($node->expr, 1)) {
                return null;
            }
            if ($this->nodeTypeResolver->isNumberType($node->var)) {
                return $node->var;
            }
        }
        return null;
    }
    /**
     * @return \PhpParser\Node\Expr|null
     */
    private function processBinaryOp(\PhpParser\Node $node)
    {
        if ($node instanceof \PhpParser\Node\Expr\BinaryOp\Plus || $node instanceof \PhpParser\Node\Expr\BinaryOp\Minus) {
            return $this->processBinaryPlusAndMinus($node);
        }
        // *, /
        if ($node instanceof \PhpParser\Node\Expr\BinaryOp\Mul) {
            return $this->processBinaryMulAndDiv($node);
        }
        if ($node instanceof \PhpParser\Node\Expr\BinaryOp\Div) {
            return $this->processBinaryMulAndDiv($node);
        }
        return null;
    }
    /**
     * @param Plus|Minus $binaryOp
     * @return \PhpParser\Node\Expr|null
     */
    private function processBinaryPlusAndMinus(\PhpParser\Node\Expr\BinaryOp $binaryOp)
    {
        if ($this->valueResolver->isValue($binaryOp->left, 0) && $this->nodeTypeResolver->isNumberType($binaryOp->right)) {
            if ($binaryOp instanceof \PhpParser\Node\Expr\BinaryOp\Minus) {
                return new \PhpParser\Node\Expr\UnaryMinus($binaryOp->right);
            }
            return $binaryOp->right;
        }
        if (!$this->valueResolver->isValue($binaryOp->right, 0)) {
            return null;
        }
        if (!$this->nodeTypeResolver->isNumberType($binaryOp->left)) {
            return null;
        }
        return $binaryOp->left;
    }
    /**
     * @param Mul|Div $binaryOp
     * @return \PhpParser\Node\Expr|null
     */
    private function processBinaryMulAndDiv(\PhpParser\Node\Expr\BinaryOp $binaryOp)
    {
        if ($binaryOp instanceof \PhpParser\Node\Expr\BinaryOp\Mul && $this->valueResolver->isValue($binaryOp->left, 1) && $this->nodeTypeResolver->isNumberType($binaryOp->right)) {
            return $binaryOp->right;
        }
        if (!$this->valueResolver->isValue($binaryOp->right, 1)) {
            return null;
        }
        if (!$this->nodeTypeResolver->isNumberType($binaryOp->left)) {
            return null;
        }
        return $binaryOp->left;
    }
}
