<?php

declare (strict_types=1);
namespace Rector\DeadCode;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Expr\BinaryOp\NotEqual;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\Empty_;
use PhpParser\Node\Stmt\If_;
use PHPStan\Type\MixedType;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\NodeTypeResolver\NodeTypeResolver;
final class UselessIfCondBeforeForeachDetector
{
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * Matches:
     * !empty($values)
     */
    public function isMatchingNotEmpty(\PhpParser\Node\Stmt\If_ $if, \PhpParser\Node\Expr $foreachExpr) : bool
    {
        $cond = $if->cond;
        if (!$cond instanceof \PhpParser\Node\Expr\BooleanNot) {
            return \false;
        }
        if (!$cond->expr instanceof \PhpParser\Node\Expr\Empty_) {
            return \false;
        }
        /** @var Empty_ $empty */
        $empty = $cond->expr;
        if (!$this->betterStandardPrinter->areNodesEqual($empty->expr, $foreachExpr)) {
            return \false;
        }
        // is array though?
        $arrayType = $this->nodeTypeResolver->resolve($empty->expr);
        return !$arrayType instanceof \PHPStan\Type\MixedType;
    }
    /**
     * Matches:
     * $values !== []
     * $values != []
     * [] !== $values
     * [] != $values
     */
    public function isMatchingNotIdenticalEmptyArray(\PhpParser\Node\Stmt\If_ $if, \PhpParser\Node\Expr $foreachExpr) : bool
    {
        if (!$if->cond instanceof \PhpParser\Node\Expr\BinaryOp\NotIdentical && !$if->cond instanceof \PhpParser\Node\Expr\BinaryOp\NotEqual) {
            return \false;
        }
        /** @var NotIdentical|NotEqual $notIdentical */
        $notIdentical = $if->cond;
        return $this->isMatchingNotBinaryOp($notIdentical, $foreachExpr);
    }
    /**
     * @param NotIdentical|NotEqual $binaryOp
     */
    private function isMatchingNotBinaryOp(\PhpParser\Node\Expr\BinaryOp $binaryOp, \PhpParser\Node\Expr $foreachExpr) : bool
    {
        if ($this->isEmptyArrayAndForeachedVariable($binaryOp->left, $binaryOp->right, $foreachExpr)) {
            return \true;
        }
        return $this->isEmptyArrayAndForeachedVariable($binaryOp->right, $binaryOp->left, $foreachExpr);
    }
    private function isEmptyArrayAndForeachedVariable(\PhpParser\Node\Expr $leftExpr, \PhpParser\Node\Expr $rightExpr, \PhpParser\Node\Expr $foreachExpr) : bool
    {
        if (!$this->isEmptyArray($leftExpr)) {
            return \false;
        }
        return $this->betterStandardPrinter->areNodesEqual($foreachExpr, $rightExpr);
    }
    private function isEmptyArray(\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \PhpParser\Node\Expr\Array_) {
            return \false;
        }
        return $expr->items === [];
    }
}
