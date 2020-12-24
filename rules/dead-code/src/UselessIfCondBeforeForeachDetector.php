<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\DeadCode;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\NotEqual;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Empty_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\If_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * Matches:
     * !empty($values)
     */
    public function isMatchingNotEmpty(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\If_ $if, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $foreachExpr) : bool
    {
        $cond = $if->cond;
        if (!$cond instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BooleanNot) {
            return \false;
        }
        if (!$cond->expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Empty_) {
            return \false;
        }
        /** @var Empty_ $empty */
        $empty = $cond->expr;
        if (!$this->betterStandardPrinter->areNodesEqual($empty->expr, $foreachExpr)) {
            return \false;
        }
        // is array though?
        $arrayType = $this->nodeTypeResolver->resolve($empty->expr);
        return !$arrayType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
    }
    /**
     * Matches:
     * $values !== []
     * $values != []
     * [] !== $values
     * [] != $values
     */
    public function isMatchingNotIdenticalEmptyArray(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\If_ $if, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $foreachExpr) : bool
    {
        if (!$if->cond instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\NotIdentical && !$if->cond instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\NotEqual) {
            return \false;
        }
        /** @var NotIdentical|NotEqual $notIdentical */
        $notIdentical = $if->cond;
        return $this->isMatchingNotBinaryOp($notIdentical, $foreachExpr);
    }
    /**
     * @param NotIdentical|NotEqual $binaryOp
     */
    private function isMatchingNotBinaryOp(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp $binaryOp, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $foreachExpr) : bool
    {
        if ($this->isEmptyArrayAndForeachedVariable($binaryOp->left, $binaryOp->right, $foreachExpr)) {
            return \true;
        }
        return $this->isEmptyArrayAndForeachedVariable($binaryOp->right, $binaryOp->left, $foreachExpr);
    }
    private function isEmptyArrayAndForeachedVariable(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $leftExpr, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $rightExpr, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $foreachExpr) : bool
    {
        if (!$this->isEmptyArray($leftExpr)) {
            return \false;
        }
        return $this->betterStandardPrinter->areNodesEqual($foreachExpr, $rightExpr);
    }
    private function isEmptyArray(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_) {
            return \false;
        }
        return $expr->items === [];
    }
}
