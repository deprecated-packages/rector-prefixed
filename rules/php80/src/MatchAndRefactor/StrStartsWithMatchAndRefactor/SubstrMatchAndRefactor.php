<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php80\MatchAndRefactor\StrStartsWithMatchAndRefactor;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\Rector\Php80\Contract\StrStartWithMatchAndRefactorInterface;
use _PhpScopere8e811afab72\Rector\Php80\ValueObject\StrStartsWith;
final class SubstrMatchAndRefactor extends \_PhpScopere8e811afab72\Rector\Php80\MatchAndRefactor\StrStartsWithMatchAndRefactor\AbstractMatchAndRefactor implements \_PhpScopere8e811afab72\Rector\Php80\Contract\StrStartWithMatchAndRefactorInterface
{
    /**
     * @param Identical|NotIdentical $binaryOp
     */
    public function match(\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScopere8e811afab72\Rector\Php80\ValueObject\StrStartsWith
    {
        $isPositive = $binaryOp instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical;
        if ($this->isFuncCallName($binaryOp->left, 'substr')) {
            /** @var FuncCall $funcCall */
            $funcCall = $binaryOp->left;
            $haystack = $funcCall->args[0]->value;
            return new \_PhpScopere8e811afab72\Rector\Php80\ValueObject\StrStartsWith($funcCall, $haystack, $binaryOp->right, $isPositive);
        }
        if ($this->isFuncCallName($binaryOp->right, 'substr')) {
            /** @var FuncCall $funcCall */
            $funcCall = $binaryOp->right;
            $haystack = $funcCall->args[0]->value;
            return new \_PhpScopere8e811afab72\Rector\Php80\ValueObject\StrStartsWith($funcCall, $haystack, $binaryOp->left, $isPositive);
        }
        return null;
    }
    public function refactorStrStartsWith(\_PhpScopere8e811afab72\Rector\Php80\ValueObject\StrStartsWith $strStartsWith) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $substrFuncCall = $strStartsWith->getFuncCall();
        if (!$this->valueResolver->isValue($substrFuncCall->args[1]->value, 0)) {
            return null;
        }
        if (!$this->isFuncCallName($substrFuncCall->args[2]->value, 'strlen')) {
            return null;
        }
        /** @var FuncCall $strlenFuncCall */
        $strlenFuncCall = $substrFuncCall->args[2]->value;
        $needleExpr = $strlenFuncCall->args[0]->value;
        $comparedNeedleExpr = $strStartsWith->getNeedleExpr();
        if (!$this->betterStandardPrinter->areNodesEqual($needleExpr, $comparedNeedleExpr)) {
            return null;
        }
        return $this->createStrStartsWith($strStartsWith);
    }
}
