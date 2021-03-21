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
use Rector\Core\Util\StaticNodeInstanceOf;
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
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
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
    private function processAssignOp(\PhpParser\Node $node) : ?\PhpParser\Node\Expr
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
    private function processBinaryOp(\PhpParser\Node $node) : ?\PhpParser\Node\Expr
    {
        if (\Rector\Core\Util\StaticNodeInstanceOf::isOneOf($node, [\PhpParser\Node\Expr\BinaryOp\Plus::class, \PhpParser\Node\Expr\BinaryOp\Minus::class])) {
            /** @var Plus|Minus $node */
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
     */
    private function processBinaryPlusAndMinus(\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\PhpParser\Node\Expr
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
     */
    private function processBinaryMulAndDiv(\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\PhpParser\Node\Expr
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
