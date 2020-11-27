<?php

// lint >= 7.4
namespace _PhpScoperbd5d0c5f7638\ArrowFunctions;

class Foo
{
    public function doFoo()
    {
        $x = fn(string $str): int => 1;
        die;
    }
}
