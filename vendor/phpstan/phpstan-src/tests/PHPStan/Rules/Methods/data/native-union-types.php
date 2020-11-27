<?php

// lint >= 8.0
namespace _PhpScoperbd5d0c5f7638\NativeUnionTypesSupport;

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
