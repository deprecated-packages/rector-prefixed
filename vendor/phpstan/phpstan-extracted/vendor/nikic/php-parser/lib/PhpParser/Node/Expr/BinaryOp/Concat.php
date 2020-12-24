<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp;
class Concat extends \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '.';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Concat';
    }
}
