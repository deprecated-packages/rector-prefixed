<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BooleanOr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\AssignAndBinaryMap;
use _PhpScoper2a4e7ab1ecbc\Rector\Php71\ValueObject\TwoNodeMatch;
final class BinaryOpManipulator
{
    /**
     * @var AssignAndBinaryMap
     */
    private $assignAndBinaryMap;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\AssignAndBinaryMap $assignAndBinaryMap)
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
    public function matchFirstAndSecondConditionNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp $binaryOp, $firstCondition, $secondCondition) : ?\_PhpScoper2a4e7ab1ecbc\Rector\Php71\ValueObject\TwoNodeMatch
    {
        $this->validateCondition($firstCondition);
        $this->validateCondition($secondCondition);
        $firstCondition = $this->normalizeCondition($firstCondition);
        $secondCondition = $this->normalizeCondition($secondCondition);
        if ($firstCondition($binaryOp->left, $binaryOp->right) && $secondCondition($binaryOp->right, $binaryOp->left)) {
            return new \_PhpScoper2a4e7ab1ecbc\Rector\Php71\ValueObject\TwoNodeMatch($binaryOp->left, $binaryOp->right);
        }
        if ($firstCondition($binaryOp->right, $binaryOp->left) && $secondCondition($binaryOp->left, $binaryOp->right)) {
            return new \_PhpScoper2a4e7ab1ecbc\Rector\Php71\ValueObject\TwoNodeMatch($binaryOp->right, $binaryOp->left);
        }
        return null;
    }
    public function inverseBinaryOp(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp
    {
        // no nesting
        if ($binaryOp->left instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BooleanOr) {
            return null;
        }
        if ($binaryOp->right instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BooleanOr) {
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
    public function invertCondition(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp
    {
        // no nesting
        if ($binaryOp->left instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BooleanOr) {
            return null;
        }
        if ($binaryOp->right instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BooleanOr) {
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
        if (\is_a($firstCondition, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node::class, \true)) {
            return;
        }
        throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
    }
    /**
     * @param callable|string $condition
     */
    private function normalizeCondition($condition) : callable
    {
        if (\is_callable($condition)) {
            return $condition;
        }
        return function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) use($condition) : bool {
            return \is_a($node, $condition, \true);
        };
    }
    private function resolveInversedNodeClass(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?string
    {
        $inversedNodeClass = $this->assignAndBinaryMap->getInversed($binaryOp);
        if ($inversedNodeClass !== null) {
            return $inversedNodeClass;
        }
        if ($binaryOp instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BooleanOr) {
            return \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BooleanAnd::class;
        }
        return null;
    }
    private function inverseNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $expr) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if ($expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp) {
            $inversedBinaryOp = $this->assignAndBinaryMap->getInversed($expr);
            if ($inversedBinaryOp) {
                return new $inversedBinaryOp($expr->left, $expr->right);
            }
        }
        if ($expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BooleanNot) {
            return $expr->expr;
        }
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BooleanNot($expr);
    }
}
