<?php

declare (strict_types=1);
namespace PHPStan\PhpDocParser\Ast\ConstExpr;

class ConstExprTrueNode implements \PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
{
    public function __toString() : string
    {
        return 'true';
    }
}
