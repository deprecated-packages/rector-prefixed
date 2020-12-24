<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\NodeManipulator;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanOr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Coalesce;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\LogicalAnd;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\LogicalOr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BitwiseNot;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Clone_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Empty_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Instanceof_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Isset_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\UnaryMinus;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\UnaryPlus;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\Rector\PostRector\Collector\NodesToAddCollector;
final class LivingCodeManipulator
{
    /**
     * @var NodesToAddCollector
     */
    private $nodesToAddCollector;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\PostRector\Collector\NodesToAddCollector $nodesToAddCollector)
    {
        $this->nodesToAddCollector = $nodesToAddCollector;
    }
    public function addLivingCodeBeforeNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr, \_PhpScoperb75b35f52b74\PhpParser\Node $addBeforeThisNode) : void
    {
        $livinExprs = $this->keepLivingCodeFromExpr($expr);
        foreach ($livinExprs as $expr) {
            $this->nodesToAddCollector->addNodeBeforeNode(new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($expr), $addBeforeThisNode);
        }
    }
    /**
     * @param Node|int|string|null $expr
     * @return Expr[]|mixed[]
     */
    public function keepLivingCodeFromExpr($expr) : array
    {
        if (!$expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr) {
            return [];
        }
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure || $expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar || $expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch) {
            return [];
        }
        if ($this->isNestedExpr($expr)) {
            return $this->keepLivingCodeFromExpr($expr->expr);
        }
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            return $this->keepLivingCodeFromExpr($expr->name);
        }
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
            return \array_merge($this->keepLivingCodeFromExpr($expr->var), $this->keepLivingCodeFromExpr($expr->name));
        }
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch) {
            return \array_merge($this->keepLivingCodeFromExpr($expr->var), $this->keepLivingCodeFromExpr($expr->dim));
        }
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch || $expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch) {
            return \array_merge($this->keepLivingCodeFromExpr($expr->class), $this->keepLivingCodeFromExpr($expr->name));
        }
        if ($this->isBinaryOpWithoutChange($expr)) {
            /** @var BinaryOp $binaryOp */
            $binaryOp = $expr;
            return $this->processBinary($binaryOp);
        }
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Instanceof_) {
            return \array_merge($this->keepLivingCodeFromExpr($expr->expr), $this->keepLivingCodeFromExpr($expr->class));
        }
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Isset_) {
            return $this->processIsset($expr);
        }
        return [$expr];
    }
    private function isNestedExpr(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        return $expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast || $expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Empty_ || $expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\UnaryMinus || $expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\UnaryPlus || $expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BitwiseNot || $expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot || $expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Clone_;
    }
    private function isBinaryOpWithoutChange(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp) {
            return \false;
        }
        return !($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\LogicalAnd || $expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanAnd || $expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\LogicalOr || $expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanOr || $expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Coalesce);
    }
    /**
     * @return Expr[]
     */
    private function processBinary(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp $binaryOp) : array
    {
        return \array_merge($this->keepLivingCodeFromExpr($binaryOp->left), $this->keepLivingCodeFromExpr($binaryOp->right));
    }
    /**
     * @return mixed[]
     */
    private function processIsset(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Isset_ $isset) : array
    {
        $livingExprs = [];
        foreach ($isset->vars as $expr) {
            $livingExprs = \array_merge($livingExprs, $this->keepLivingCodeFromExpr($expr));
        }
        return $livingExprs;
    }
}
