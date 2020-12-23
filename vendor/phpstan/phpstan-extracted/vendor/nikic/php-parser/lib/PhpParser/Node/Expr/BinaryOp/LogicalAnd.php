<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp;
class LogicalAnd extends \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return 'and';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_LogicalAnd';
    }
}
