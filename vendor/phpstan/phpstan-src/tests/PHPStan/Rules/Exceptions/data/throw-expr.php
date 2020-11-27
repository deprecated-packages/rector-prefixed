<?php

// lint >= 8.0
namespace _PhpScopera143bcca66cb\ThrowExpr;

class Bar
{
    public function doFoo(bool $b) : void
    {
        $b ? \true : throw new \Exception();
        throw new \Exception();
    }
}
