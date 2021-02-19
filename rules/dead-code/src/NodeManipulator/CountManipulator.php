<?php

declare (strict_types=1);
namespace Rector\DeadCode\NodeManipulator;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\Greater;
use PhpParser\Node\Expr\BinaryOp\GreaterOrEqual;
use PhpParser\Node\Expr\BinaryOp\Smaller;
use PhpParser\Node\Expr\BinaryOp\SmallerOrEqual;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Scalar\LNumber;
use Rector\Core\PhpParser\Comparing\NodeComparator;
use Rector\NodeNameResolver\NodeNameResolver;
final class CountManipulator
{
    /**
     * @var NodeComparator
     */
    private $nodeComparator;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\Core\PhpParser\Comparing\NodeComparator $nodeComparator)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeComparator = $nodeComparator;
    }
    public function isCounterHigherThanOne(\PhpParser\Node $node, \PhpParser\Node\Expr $expr) : bool
    {
        // e.g. count($values) > 0
        if ($node instanceof \PhpParser\Node\Expr\BinaryOp\Greater) {
            return $this->processGreater($node, $expr);
        }
        // e.g. count($values) >= 1
        if ($node instanceof \PhpParser\Node\Expr\BinaryOp\GreaterOrEqual) {
            return $this->processGreaterOrEqual($node, $expr);
        }
        // e.g. 0 < count($values)
        if ($node instanceof \PhpParser\Node\Expr\BinaryOp\Smaller) {
            return $this->processSmaller($node, $expr);
        }
        // e.g. 1 <= count($values)
        if ($node instanceof \PhpParser\Node\Expr\BinaryOp\SmallerOrEqual) {
            return $this->processSmallerOrEqual($node, $expr);
        }
        return \false;
    }
    private function processGreater(\PhpParser\Node\Expr\BinaryOp\Greater $greater, \PhpParser\Node\Expr $expr) : bool
    {
        if (!$this->isNumber($greater->right, 0)) {
            return \false;
        }
        return $this->isCountWithExpression($greater->left, $expr);
    }
    private function processGreaterOrEqual(\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual $greaterOrEqual, \PhpParser\Node\Expr $expr) : bool
    {
        if (!$this->isNumber($greaterOrEqual->right, 1)) {
            return \false;
        }
        return $this->isCountWithExpression($greaterOrEqual->left, $expr);
    }
    private function processSmaller(\PhpParser\Node\Expr\BinaryOp\Smaller $smaller, \PhpParser\Node\Expr $expr) : bool
    {
        if (!$this->isNumber($smaller->left, 0)) {
            return \false;
        }
        return $this->isCountWithExpression($smaller->right, $expr);
    }
    private function processSmallerOrEqual(\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual $smallerOrEqual, \PhpParser\Node\Expr $expr) : bool
    {
        if (!$this->isNumber($smallerOrEqual->left, 1)) {
            return \false;
        }
        return $this->isCountWithExpression($smallerOrEqual->right, $expr);
    }
    private function isNumber(\PhpParser\Node $node, int $value) : bool
    {
        if (!$node instanceof \PhpParser\Node\Scalar\LNumber) {
            return \false;
        }
        return $node->value === $value;
    }
    private function isCountWithExpression(\PhpParser\Node $node, \PhpParser\Node\Expr $expr) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($node, 'count')) {
            return \false;
        }
        $countedExpr = $node->args[0]->value;
        return $this->nodeComparator->areNodesEqual($countedExpr, $expr);
    }
}
