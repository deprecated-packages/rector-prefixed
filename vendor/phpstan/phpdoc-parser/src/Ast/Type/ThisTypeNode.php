<?php

declare (strict_types=1);
namespace PHPStan\PhpDocParser\Ast\Type;

class ThisTypeNode implements \PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    public function __toString() : string
    {
        return '$this';
    }
}
