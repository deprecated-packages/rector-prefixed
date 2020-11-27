<?php

// lint >= 8.0
namespace _PhpScoperbd5d0c5f7638\ThrowExpr;

class Bar
{
    public function doFoo(bool $b) : void
    {
        $b ? \true : throw new \Exception();
        throw new \Exception();
    }
}
