<?php

namespace _PhpScoper88fe6e0ad041\ParameterTypeWidening;

class Foo
{
    public function doFoo(string $foo) : void
    {
    }
}
class Bar extends \_PhpScoper88fe6e0ad041\ParameterTypeWidening\Foo
{
    public function doFoo($foo) : void
    {
    }
}
