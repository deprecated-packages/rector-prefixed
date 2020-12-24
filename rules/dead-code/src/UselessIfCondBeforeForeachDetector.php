<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotEqual;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Empty_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * Matches:
     * !empty($values)
     */
    public function isMatchingNotEmpty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_ $if, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $foreachExpr) : bool
    {
        $cond = $if->cond;
        if (!$cond instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot) {
            return \false;
        }
        if (!$cond->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Empty_) {
            return \false;
        }
        /** @var Empty_ $empty */
        $empty = $cond->expr;
        if (!$this->betterStandardPrinter->areNodesEqual($empty->expr, $foreachExpr)) {
            return \false;
        }
        // is array though?
        $arrayType = $this->nodeTypeResolver->resolve($empty->expr);
        return !$arrayType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
    }
    /**
     * Matches:
     * $values !== []
     * $values != []
     * [] !== $values
     * [] != $values
     */
    public function isMatchingNotIdenticalEmptyArray(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_ $if, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $foreachExpr) : bool
    {
        if (!$if->cond instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical && !$if->cond instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotEqual) {
            return \false;
        }
        /** @var NotIdentical|NotEqual $notIdentical */
        $notIdentical = $if->cond;
        return $this->isMatchingNotBinaryOp($notIdentical, $foreachExpr);
    }
    /**
     * @param NotIdentical|NotEqual $binaryOp
     */
    private function isMatchingNotBinaryOp(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp $binaryOp, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $foreachExpr) : bool
    {
        if ($this->isEmptyArrayAndForeachedVariable($binaryOp->left, $binaryOp->right, $foreachExpr)) {
            return \true;
        }
        return $this->isEmptyArrayAndForeachedVariable($binaryOp->right, $binaryOp->left, $foreachExpr);
    }
    private function isEmptyArrayAndForeachedVariable(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $leftExpr, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $rightExpr, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $foreachExpr) : bool
    {
        if (!$this->isEmptyArray($leftExpr)) {
            return \false;
        }
        return $this->betterStandardPrinter->areNodesEqual($foreachExpr, $rightExpr);
    }
    private function isEmptyArray(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_) {
            return \false;
        }
        return $expr->items === [];
    }
}
