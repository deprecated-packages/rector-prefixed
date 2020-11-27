<?php

// lint >= 7.4
namespace _PhpScoperbd5d0c5f7638\ArrowFunctionsInside;

class Foo
{
    public function doFoo(int $i)
    {
        fn(string $s) => die;
    }
}
