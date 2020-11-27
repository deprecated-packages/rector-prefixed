<?php

// lint >= 7.4
namespace _PhpScopera143bcca66cb\ArrowFunctions;

class Foo
{
    public function doFoo()
    {
        $x = fn(string $str): int => 1;
        die;
    }
}
