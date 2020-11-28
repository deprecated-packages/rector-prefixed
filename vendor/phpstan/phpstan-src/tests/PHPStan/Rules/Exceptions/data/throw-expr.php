<?php

// lint >= 8.0
namespace _PhpScoperabd03f0baf05\ThrowExpr;

class Bar
{
    public function doFoo(bool $b) : void
    {
        $b ? \true : throw new \Exception();
        throw new \Exception();
    }
}
