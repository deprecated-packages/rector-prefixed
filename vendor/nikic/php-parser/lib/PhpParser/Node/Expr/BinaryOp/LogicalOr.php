<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp;
class LogicalOr extends \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return 'or';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_LogicalOr';
    }
}
