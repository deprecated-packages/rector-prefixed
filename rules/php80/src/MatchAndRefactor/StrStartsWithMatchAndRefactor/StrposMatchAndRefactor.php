<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php80\MatchAndRefactor\StrStartsWithMatchAndRefactor;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\Rector\Php80\Contract\StrStartWithMatchAndRefactorInterface;
use _PhpScopere8e811afab72\Rector\Php80\ValueObject\StrStartsWith;
final class StrposMatchAndRefactor extends \_PhpScopere8e811afab72\Rector\Php80\MatchAndRefactor\StrStartsWithMatchAndRefactor\AbstractMatchAndRefactor implements \_PhpScopere8e811afab72\Rector\Php80\Contract\StrStartWithMatchAndRefactorInterface
{
    /**
     * @param Identical|NotIdentical $binaryOp
     */
    public function match(\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScopere8e811afab72\Rector\Php80\ValueObject\StrStartsWith
    {
        $isPositive = $binaryOp instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical;
        if ($this->isFuncCallName($binaryOp->left, 'strpos')) {
            if (!$this->valueResolver->isValue($binaryOp->right, 0)) {
                return null;
            }
            /** @var FuncCall $funcCall */
            $funcCall = $binaryOp->left;
            $haystack = $funcCall->args[0]->value;
            $needle = $funcCall->args[1]->value;
            return new \_PhpScopere8e811afab72\Rector\Php80\ValueObject\StrStartsWith($funcCall, $haystack, $needle, $isPositive);
        }
        if ($this->isFuncCallName($binaryOp->right, 'strpos')) {
            if (!$this->valueResolver->isValue($binaryOp->left, 0)) {
                return null;
            }
            /** @var FuncCall $funcCall */
            $funcCall = $binaryOp->right;
            $haystack = $funcCall->args[0]->value;
            $needle = $funcCall->args[1]->value;
            return new \_PhpScopere8e811afab72\Rector\Php80\ValueObject\StrStartsWith($funcCall, $haystack, $needle, $isPositive);
        }
        return null;
    }
    public function refactorStrStartsWith(\_PhpScopere8e811afab72\Rector\Php80\ValueObject\StrStartsWith $strStartsWith) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $strposFuncCall = $strStartsWith->getFuncCall();
        $strposFuncCall->name = new \_PhpScopere8e811afab72\PhpParser\Node\Name('str_starts_with');
        return $this->createStrStartsWith($strStartsWith);
    }
}
