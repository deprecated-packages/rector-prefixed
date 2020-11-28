<?php

namespace _PhpScoperabd03f0baf05\VariadicParameterAlwaysOptional;

class Foo
{
    public function doFoo(string ...$test) : void
    {
    }
    public function doBar() : void
    {
    }
}
class Bar extends \_PhpScoperabd03f0baf05\VariadicParameterAlwaysOptional\Foo
{
    public function doFoo(string ...$test) : void
    {
    }
    public function doBar(...$test) : void
    {
    }
}
