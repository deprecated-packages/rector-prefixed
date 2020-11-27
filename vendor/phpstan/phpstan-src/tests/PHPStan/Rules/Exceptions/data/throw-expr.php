<?php

// lint >= 8.0
namespace _PhpScoper88fe6e0ad041\ThrowExpr;

class Bar
{
    public function doFoo(bool $b) : void
    {
        $b ? \true : throw new \Exception();
        throw new \Exception();
    }
}
