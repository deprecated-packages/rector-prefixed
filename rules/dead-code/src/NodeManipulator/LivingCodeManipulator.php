<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\NodeManipulator;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanOr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Coalesce;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\LogicalAnd;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\LogicalOr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BitwiseNot;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Cast;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Clone_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Closure;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Empty_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Instanceof_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Isset_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\UnaryMinus;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\UnaryPlus;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Rector\PostRector\Collector\NodesToAddCollector;
final class LivingCodeManipulator
{
    /**
     * @var NodesToAddCollector
     */
    private $nodesToAddCollector;
    public function __construct(\_PhpScopere8e811afab72\Rector\PostRector\Collector\NodesToAddCollector $nodesToAddCollector)
    {
        $this->nodesToAddCollector = $nodesToAddCollector;
    }
    public function addLivingCodeBeforeNode(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr, \_PhpScopere8e811afab72\PhpParser\Node $addBeforeThisNode) : void
    {
        $livinExprs = $this->keepLivingCodeFromExpr($expr);
        foreach ($livinExprs as $expr) {
            $this->nodesToAddCollector->addNodeBeforeNode(new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($expr), $addBeforeThisNode);
        }
    }
    /**
     * @param Node|int|string|null $expr
     * @return Expr[]|mixed[]
     */
    public function keepLivingCodeFromExpr($expr) : array
    {
        if (!$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr) {
            return [];
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Closure || $expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar || $expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch) {
            return [];
        }
        if ($this->isNestedExpr($expr)) {
            return $this->keepLivingCodeFromExpr($expr->expr);
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return $this->keepLivingCodeFromExpr($expr->name);
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            return \array_merge($this->keepLivingCodeFromExpr($expr->var), $this->keepLivingCodeFromExpr($expr->name));
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
            return \array_merge($this->keepLivingCodeFromExpr($expr->var), $this->keepLivingCodeFromExpr($expr->dim));
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch || $expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch) {
            return \array_merge($this->keepLivingCodeFromExpr($expr->class), $this->keepLivingCodeFromExpr($expr->name));
        }
        if ($this->isBinaryOpWithoutChange($expr)) {
            /** @var BinaryOp $binaryOp */
            $binaryOp = $expr;
            return $this->processBinary($binaryOp);
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Instanceof_) {
            return \array_merge($this->keepLivingCodeFromExpr($expr->expr), $this->keepLivingCodeFromExpr($expr->class));
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Isset_) {
            return $this->processIsset($expr);
        }
        return [$expr];
    }
    private function isNestedExpr(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : bool
    {
        return $expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast || $expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Empty_ || $expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\UnaryMinus || $expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\UnaryPlus || $expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BitwiseNot || $expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot || $expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Clone_;
    }
    private function isBinaryOpWithoutChange(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp) {
            return \false;
        }
        return !($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\LogicalAnd || $expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanAnd || $expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\LogicalOr || $expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanOr || $expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Coalesce);
    }
    /**
     * @return Expr[]
     */
    private function processBinary(\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp $binaryOp) : array
    {
        return \array_merge($this->keepLivingCodeFromExpr($binaryOp->left), $this->keepLivingCodeFromExpr($binaryOp->right));
    }
    /**
     * @return mixed[]
     */
    private function processIsset(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Isset_ $isset) : array
    {
        $livingExprs = [];
        foreach ($isset->vars as $expr) {
            $livingExprs = \array_merge($livingExprs, $this->keepLivingCodeFromExpr($expr));
        }
        return $livingExprs;
    }
}
