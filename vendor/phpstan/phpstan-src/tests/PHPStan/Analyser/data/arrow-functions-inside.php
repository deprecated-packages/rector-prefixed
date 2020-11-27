<?php

// lint >= 7.4
namespace _PhpScoper006a73f0e455\ArrowFunctionsInside;

class Foo
{
    public function doFoo(int $i)
    {
        fn(string $s) => die;
    }
}
