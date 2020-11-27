<?php

// lint >= 7.4
namespace _PhpScoper26e51eeacccf\ArrowFunctionsInside;

class Foo
{
    public function doFoo(int $i)
    {
        fn(string $s) => die;
    }
}
