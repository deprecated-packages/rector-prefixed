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
final class StrncmpMatchAndRefactor extends \_PhpScopere8e811afab72\Rector\Php80\MatchAndRefactor\StrStartsWithMatchAndRefactor\AbstractMatchAndRefactor implements \_PhpScopere8e811afab72\Rector\Php80\Contract\StrStartWithMatchAndRefactorInterface
{
    /**
     * @var string
     */
    private const FUNCTION_NAME = 'strncmp';
    /**
     * @param Identical|NotIdentical $binaryOp
     */
    public function match(\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScopere8e811afab72\Rector\Php80\ValueObject\StrStartsWith
    {
        $isPositive = $binaryOp instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical;
        if ($this->isFuncCallName($binaryOp->left, self::FUNCTION_NAME)) {
            return $this->createStrStartsWithValueObjectFromFuncCall($binaryOp->left, $isPositive);
        }
        if ($this->isFuncCallName($binaryOp->right, self::FUNCTION_NAME)) {
            return $this->createStrStartsWithValueObjectFromFuncCall($binaryOp->right, $isPositive);
        }
        return null;
    }
    public function refactorStrStartsWith(\_PhpScopere8e811afab72\Rector\Php80\ValueObject\StrStartsWith $strStartsWith) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $strncmpFuncCall = $strStartsWith->getFuncCall();
        $needleExpr = $strStartsWith->getNeedleExpr();
        if (!$this->isFuncCallName($strncmpFuncCall->args[2]->value, 'strlen')) {
            return null;
        }
        /** @var FuncCall $strlenFuncCall */
        $strlenFuncCall = $strncmpFuncCall->args[2]->value;
        $strlenArgumentValue = $strlenFuncCall->args[0]->value;
        if (!$this->betterStandardPrinter->areNodesEqual($needleExpr, $strlenArgumentValue)) {
            return null;
        }
        return $this->createStrStartsWith($strStartsWith);
    }
}
