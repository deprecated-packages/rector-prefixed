<?php

// lint >= 8.0
namespace _PhpScoper006a73f0e455\ThrowExpr;

class Bar
{
    public function doFoo(bool $b) : void
    {
        $b ? \true : throw new \Exception();
        throw new \Exception();
    }
}
