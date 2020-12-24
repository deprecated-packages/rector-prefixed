<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanOr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\AssignAndBinaryMap;
use _PhpScoperb75b35f52b74\Rector\Php71\ValueObject\TwoNodeMatch;
final class BinaryOpManipulator
{
    /**
     * @var AssignAndBinaryMap
     */
    private $assignAndBinaryMap;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\AssignAndBinaryMap $assignAndBinaryMap)
    {
        $this->assignAndBinaryMap = $assignAndBinaryMap;
    }
    /**
     * Tries to match left or right parts (xor),
     * returns null or match on first condition and then second condition. No matter what the origin order is.
     *
     * @param callable|string $firstCondition callable or Node to instanceof
     * @param callable|string $secondCondition callable or Node to instanceof
     */
    public function matchFirstAndSecondConditionNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp $binaryOp, $firstCondition, $secondCondition) : ?\_PhpScoperb75b35f52b74\Rector\Php71\ValueObject\TwoNodeMatch
    {
        $this->validateCondition($firstCondition);
        $this->validateCondition($secondCondition);
        $firstCondition = $this->normalizeCondition($firstCondition);
        $secondCondition = $this->normalizeCondition($secondCondition);
        if ($firstCondition($binaryOp->left, $binaryOp->right) && $secondCondition($binaryOp->right, $binaryOp->left)) {
            return new \_PhpScoperb75b35f52b74\Rector\Php71\ValueObject\TwoNodeMatch($binaryOp->left, $binaryOp->right);
        }
        if ($firstCondition($binaryOp->right, $binaryOp->left) && $secondCondition($binaryOp->left, $binaryOp->right)) {
            return new \_PhpScoperb75b35f52b74\Rector\Php71\ValueObject\TwoNodeMatch($binaryOp->right, $binaryOp->left);
        }
        return null;
    }
    public function inverseBinaryOp(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp
    {
        // no nesting
        if ($binaryOp->left instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanOr) {
            return null;
        }
        if ($binaryOp->right instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanOr) {
            return null;
        }
        $inversedNodeClass = $this->resolveInversedNodeClass($binaryOp);
        if ($inversedNodeClass === null) {
            return null;
        }
        $firstInversedNode = $this->inverseNode($binaryOp->left);
        $secondInversedNode = $this->inverseNode($binaryOp->right);
        return new $inversedNodeClass($firstInversedNode, $secondInversedNode);
    }
    public function invertCondition(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp
    {
        // no nesting
        if ($binaryOp->left instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanOr) {
            return null;
        }
        if ($binaryOp->right instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanOr) {
            return null;
        }
        $inversedNodeClass = $this->resolveInversedNodeClass($binaryOp);
        if ($inversedNodeClass === null) {
            return null;
        }
        return new $inversedNodeClass($binaryOp->left, $binaryOp->right);
    }
    /**
     * @param string|callable $firstCondition
     */
    private function validateCondition($firstCondition) : void
    {
        if (\is_callable($firstCondition)) {
            return;
        }
        if (\is_a($firstCondition, \_PhpScoperb75b35f52b74\PhpParser\Node::class, \true)) {
            return;
        }
        throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
    }
    /**
     * @param callable|string $condition
     */
    private function normalizeCondition($condition) : callable
    {
        if (\is_callable($condition)) {
            return $condition;
        }
        return function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($condition) : bool {
            return \is_a($node, $condition, \true);
        };
    }
    private function resolveInversedNodeClass(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?string
    {
        $inversedNodeClass = $this->assignAndBinaryMap->getInversed($binaryOp);
        if ($inversedNodeClass !== null) {
            return $inversedNodeClass;
        }
        if ($binaryOp instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanOr) {
            return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanAnd::class;
        }
        return null;
    }
    private function inverseNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : \_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp) {
            $inversedBinaryOp = $this->assignAndBinaryMap->getInversed($expr);
            if ($inversedBinaryOp) {
                return new $inversedBinaryOp($expr->left, $expr->right);
            }
        }
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot) {
            return $expr->expr;
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot($expr);
    }
}
