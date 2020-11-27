<?php

// lint >= 7.4
namespace _PhpScopera143bcca66cb\ArrowFunctionsInside;

class Foo
{
    public function doFoo(int $i)
    {
        fn(string $s) => die;
    }
}
