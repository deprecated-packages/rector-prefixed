<?php

namespace _PhpScopera143bcca66cb\ParameterTypeWidening;

class Foo
{
    public function doFoo(string $foo) : void
    {
    }
}
class Bar extends \_PhpScopera143bcca66cb\ParameterTypeWidening\Foo
{
    public function doFoo($foo) : void
    {
    }
}
