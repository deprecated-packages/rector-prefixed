<?php

declare (strict_types=1);
namespace Rector\DeadCode\NodeManipulator;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;
use PhpParser\Node\Expr\BinaryOp\Coalesce;
use PhpParser\Node\Expr\BinaryOp\LogicalAnd;
use PhpParser\Node\Expr\BinaryOp\LogicalOr;
use PhpParser\Node\Expr\BitwiseNot;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\Cast;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\Clone_;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\Empty_;
use PhpParser\Node\Expr\Instanceof_;
use PhpParser\Node\Expr\Isset_;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Expr\UnaryMinus;
use PhpParser\Node\Expr\UnaryPlus;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar;
use PhpParser\Node\Stmt\Expression;
use Rector\Core\Util\StaticNodeInstanceOf;
use Rector\PostRector\Collector\NodesToAddCollector;
final class LivingCodeManipulator
{
    /**
     * @var NodesToAddCollector
     */
    private $nodesToAddCollector;
    public function __construct(\Rector\PostRector\Collector\NodesToAddCollector $nodesToAddCollector)
    {
        $this->nodesToAddCollector = $nodesToAddCollector;
    }
    public function addLivingCodeBeforeNode(\PhpParser\Node\Expr $expr, \PhpParser\Node $addBeforeThisNode) : void
    {
        $livinExprs = $this->keepLivingCodeFromExpr($expr);
        foreach ($livinExprs as $livinExpr) {
            $this->nodesToAddCollector->addNodeBeforeNode(new \PhpParser\Node\Stmt\Expression($livinExpr), $addBeforeThisNode);
        }
    }
    /**
     * @param Node|int|string|null $expr
     * @return Expr[]|mixed[]
     */
    public function keepLivingCodeFromExpr($expr) : array
    {
        if (!$expr instanceof \PhpParser\Node\Expr) {
            return [];
        }
        if (\Rector\Core\Util\StaticNodeInstanceOf::isOneOf($expr, [\PhpParser\Node\Expr\Closure::class, \PhpParser\Node\Scalar::class, \PhpParser\Node\Expr\ConstFetch::class])) {
            return [];
        }
        if ($this->isNestedExpr($expr)) {
            return $this->keepLivingCodeFromExpr($expr->expr);
        }
        if ($expr instanceof \PhpParser\Node\Expr\Variable) {
            return $this->keepLivingCodeFromExpr($expr->name);
        }
        if ($expr instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return \array_merge($this->keepLivingCodeFromExpr($expr->var), $this->keepLivingCodeFromExpr($expr->name));
        }
        if ($expr instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
            return \array_merge($this->keepLivingCodeFromExpr($expr->var), $this->keepLivingCodeFromExpr($expr->dim));
        }
        if (\Rector\Core\Util\StaticNodeInstanceOf::isOneOf($expr, [\PhpParser\Node\Expr\ClassConstFetch::class, \PhpParser\Node\Expr\StaticPropertyFetch::class])) {
            /** @var ClassConstFetch|StaticPropertyFetch $expr */
            return \array_merge($this->keepLivingCodeFromExpr($expr->class), $this->keepLivingCodeFromExpr($expr->name));
        }
        if ($this->isBinaryOpWithoutChange($expr)) {
            /** @var BinaryOp $binaryOp */
            $binaryOp = $expr;
            return $this->processBinary($binaryOp);
        }
        if ($expr instanceof \PhpParser\Node\Expr\Instanceof_) {
            return \array_merge($this->keepLivingCodeFromExpr($expr->expr), $this->keepLivingCodeFromExpr($expr->class));
        }
        if ($expr instanceof \PhpParser\Node\Expr\Isset_) {
            return $this->processIsset($expr);
        }
        return [$expr];
    }
    private function isNestedExpr(\PhpParser\Node\Expr $expr) : bool
    {
        return $expr instanceof \PhpParser\Node\Expr\Cast || $expr instanceof \PhpParser\Node\Expr\Empty_ || $expr instanceof \PhpParser\Node\Expr\UnaryMinus || $expr instanceof \PhpParser\Node\Expr\UnaryPlus || $expr instanceof \PhpParser\Node\Expr\BitwiseNot || $expr instanceof \PhpParser\Node\Expr\BooleanNot || $expr instanceof \PhpParser\Node\Expr\Clone_;
    }
    private function isBinaryOpWithoutChange(\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \PhpParser\Node\Expr\BinaryOp) {
            return \false;
        }
        return !($expr instanceof \PhpParser\Node\Expr\BinaryOp\LogicalAnd || $expr instanceof \PhpParser\Node\Expr\BinaryOp\BooleanAnd || $expr instanceof \PhpParser\Node\Expr\BinaryOp\LogicalOr || $expr instanceof \PhpParser\Node\Expr\BinaryOp\BooleanOr || $expr instanceof \PhpParser\Node\Expr\BinaryOp\Coalesce);
    }
    /**
     * @return Expr[]
     */
    private function processBinary(\PhpParser\Node\Expr\BinaryOp $binaryOp) : array
    {
        return \array_merge($this->keepLivingCodeFromExpr($binaryOp->left), $this->keepLivingCodeFromExpr($binaryOp->right));
    }
    /**
     * @return mixed[]
     */
    private function processIsset(\PhpParser\Node\Expr\Isset_ $isset) : array
    {
        $livingExprs = [];
        foreach ($isset->vars as $expr) {
            $livingExprs = \array_merge($livingExprs, $this->keepLivingCodeFromExpr($expr));
        }
        return $livingExprs;
    }
}
