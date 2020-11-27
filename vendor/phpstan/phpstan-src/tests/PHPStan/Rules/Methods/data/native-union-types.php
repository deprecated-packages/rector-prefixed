<?php

// lint >= 8.0
namespace _PhpScoper88fe6e0ad041\NativeUnionTypesSupport;

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
