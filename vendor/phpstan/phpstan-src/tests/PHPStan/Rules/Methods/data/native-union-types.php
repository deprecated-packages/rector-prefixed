<?php

// lint >= 8.0
namespace _PhpScoper26e51eeacccf\NativeUnionTypesSupport;

class Foo
{
    public function doFoo(int|bool $foo) : int|bool
    {
        return 1;
    }
    public function doBar() : int|bool
    {
    }
}
