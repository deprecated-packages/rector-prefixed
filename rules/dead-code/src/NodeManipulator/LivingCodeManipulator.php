<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DeadCode\NodeManipulator;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\BooleanOr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Coalesce;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\LogicalAnd;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\LogicalOr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BitwiseNot;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Cast;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Clone_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Closure;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ConstFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Empty_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Instanceof_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Isset_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\UnaryMinus;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\UnaryPlus;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\Rector\PostRector\Collector\NodesToAddCollector;
final class LivingCodeManipulator
{
    /**
     * @var NodesToAddCollector
     */
    private $nodesToAddCollector;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\PostRector\Collector\NodesToAddCollector $nodesToAddCollector)
    {
        $this->nodesToAddCollector = $nodesToAddCollector;
    }
    public function addLivingCodeBeforeNode(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr, \_PhpScoper0a2ac50786fa\PhpParser\Node $addBeforeThisNode) : void
    {
        $livinExprs = $this->keepLivingCodeFromExpr($expr);
        foreach ($livinExprs as $expr) {
            $this->nodesToAddCollector->addNodeBeforeNode(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression($expr), $addBeforeThisNode);
        }
    }
    /**
     * @param Node|int|string|null $expr
     * @return Expr[]|mixed[]
     */
    public function keepLivingCodeFromExpr($expr) : array
    {
        if (!$expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr) {
            return [];
        }
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Closure || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ConstFetch) {
            return [];
        }
        if ($this->isNestedExpr($expr)) {
            return $this->keepLivingCodeFromExpr($expr->expr);
        }
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
            return $this->keepLivingCodeFromExpr($expr->name);
        }
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch) {
            return \array_merge($this->keepLivingCodeFromExpr($expr->var), $this->keepLivingCodeFromExpr($expr->name));
        }
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch) {
            return \array_merge($this->keepLivingCodeFromExpr($expr->var), $this->keepLivingCodeFromExpr($expr->dim));
        }
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch) {
            return \array_merge($this->keepLivingCodeFromExpr($expr->class), $this->keepLivingCodeFromExpr($expr->name));
        }
        if ($this->isBinaryOpWithoutChange($expr)) {
            /** @var BinaryOp $binaryOp */
            $binaryOp = $expr;
            return $this->processBinary($binaryOp);
        }
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Instanceof_) {
            return \array_merge($this->keepLivingCodeFromExpr($expr->expr), $this->keepLivingCodeFromExpr($expr->class));
        }
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Isset_) {
            return $this->processIsset($expr);
        }
        return [$expr];
    }
    private function isNestedExpr(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : bool
    {
        return $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Cast || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Empty_ || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\UnaryMinus || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\UnaryPlus || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BitwiseNot || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Clone_;
    }
    private function isBinaryOpWithoutChange(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp) {
            return \false;
        }
        return !($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\LogicalAnd || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\BooleanAnd || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\LogicalOr || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\BooleanOr || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Coalesce);
    }
    /**
     * @return Expr[]
     */
    private function processBinary(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp $binaryOp) : array
    {
        return \array_merge($this->keepLivingCodeFromExpr($binaryOp->left), $this->keepLivingCodeFromExpr($binaryOp->right));
    }
    /**
     * @return mixed[]
     */
    private function processIsset(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Isset_ $isset) : array
    {
        $livingExprs = [];
        foreach ($isset->vars as $expr) {
            $livingExprs = \array_merge($livingExprs, $this->keepLivingCodeFromExpr($expr));
        }
        return $livingExprs;
    }
}
