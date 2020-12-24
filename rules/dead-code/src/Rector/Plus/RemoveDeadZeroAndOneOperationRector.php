<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\Rector\Plus;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Div as AssignDiv;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Minus as AssignMinus;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Mul as AssignMul;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Plus as AssignPlus;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Div;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Minus;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Mul;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Plus;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\UnaryMinus;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/I0BGs
 *
 * @see \Rector\DeadCode\Tests\Rector\Plus\RemoveDeadZeroAndOneOperationRector\RemoveDeadZeroAndOneOperationRectorTest
 */
final class RemoveDeadZeroAndOneOperationRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove operation with 1 and 0, that have no effect on the value', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Plus::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Minus::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Mul::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Div::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Plus::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Minus::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Mul::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Div::class];
    }
    /**
     * @param Plus|Minus|Mul|Div|AssignPlus|AssignMinus|AssignMul|AssignDiv $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $changedNode = null;
        $previousNode = $node;
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp) {
            $changedNode = $this->processAssignOp($node);
        }
        // -, +
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp) {
            $changedNode = $this->processBinaryOp($node);
        }
        // recurse nested combinations
        while ($changedNode !== null && !$this->areNodesEqual($previousNode, $changedNode)) {
            $previousNode = $changedNode;
            if ($changedNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp || $changedNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp) {
                $changedNode = $this->refactor($changedNode);
            }
            // nothing more to change, return last node
            if ($changedNode === null) {
                return $previousNode;
            }
        }
        return $changedNode;
    }
    private function processAssignOp(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        // +=, -=
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Plus || $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Minus) {
            if (!$this->isValue($node->expr, 0)) {
                return null;
            }
            if ($this->isNumberType($node->var)) {
                return $node->var;
            }
        }
        // *, /
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Mul || $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Div) {
            if (!$this->isValue($node->expr, 1)) {
                return null;
            }
            if ($this->isNumberType($node->var)) {
                return $node->var;
            }
        }
        return null;
    }
    private function processBinaryOp(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Plus || $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Minus) {
            return $this->processBinaryPlusAndMinus($node);
        }
        // *, /
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Mul || $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Div) {
            return $this->processBinaryMulAndDiv($node);
        }
        return null;
    }
    /**
     * @param Plus|Minus $binaryOp
     */
    private function processBinaryPlusAndMinus(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        if ($this->isValue($binaryOp->left, 0) && $this->isNumberType($binaryOp->right)) {
            if ($binaryOp instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Minus) {
                return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\UnaryMinus($binaryOp->right);
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
    private function processBinaryMulAndDiv(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        if ($binaryOp instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Mul && $this->isValue($binaryOp->left, 1) && $this->isNumberType($binaryOp->right)) {
            return $binaryOp->right;
        }
        if ($this->isValue($binaryOp->right, 1) && $this->isNumberType($binaryOp->left)) {
            return $binaryOp->left;
        }
        return null;
    }
}
