<?php

// lint >= 8.0
namespace _PhpScoper26e51eeacccf\ThrowExpr;

class Bar
{
    public function doFoo(bool $b) : void
    {
        $b ? \true : throw new \Exception();
        throw new \Exception();
    }
}
