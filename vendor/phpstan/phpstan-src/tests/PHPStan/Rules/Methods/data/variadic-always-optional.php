<?php

namespace _PhpScoper26e51eeacccf\VariadicParameterAlwaysOptional;

class Foo
{
    public function doFoo(string ...$test) : void
    {
    }
    public function doBar() : void
    {
    }
}
class Bar extends \_PhpScoper26e51eeacccf\VariadicParameterAlwaysOptional\Foo
{
    public function doFoo(string ...$test) : void
    {
    }
    public function doBar(...$test) : void
    {
    }
}
