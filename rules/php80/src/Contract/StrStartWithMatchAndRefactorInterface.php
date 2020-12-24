<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php80\Contract;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\Rector\Php80\ValueObject\StrStartsWith;
interface StrStartWithMatchAndRefactorInterface
{
    public function match(\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScopere8e811afab72\Rector\Php80\ValueObject\StrStartsWith;
    /**
     * @return FuncCall|BooleanNot|null
     */
    public function refactorStrStartsWith(\_PhpScopere8e811afab72\Rector\Php80\ValueObject\StrStartsWith $strStartsWith) : ?\_PhpScopere8e811afab72\PhpParser\Node;
}
