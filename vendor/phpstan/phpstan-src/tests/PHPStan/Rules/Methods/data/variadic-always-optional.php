<?php

namespace _PhpScoper88fe6e0ad041\VariadicParameterAlwaysOptional;

class Foo
{
    public function doFoo(string ...$test) : void
    {
    }
    public function doBar() : void
    {
    }
}
class Bar extends \_PhpScoper88fe6e0ad041\VariadicParameterAlwaysOptional\Foo
{
    public function doFoo(string ...$test) : void
    {
    }
    public function doBar(...$test) : void
    {
    }
}
