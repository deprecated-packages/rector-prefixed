<?php

// lint >= 8.0
namespace _PhpScopera143bcca66cb\InstantiationNamedArguments;

class Foo
{
    public function __construct(int $i, int $j)
    {
    }
    public function doFoo()
    {
        $s = new self(i: 1);
        $r = new self(i: 1, j: 2, z: 3);
    }
}
