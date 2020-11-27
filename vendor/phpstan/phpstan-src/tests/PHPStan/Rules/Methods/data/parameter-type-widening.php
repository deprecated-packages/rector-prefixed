<?php

namespace _PhpScoper26e51eeacccf\ParameterTypeWidening;

class Foo
{
    public function doFoo(string $foo) : void
    {
    }
}
class Bar extends \_PhpScoper26e51eeacccf\ParameterTypeWidening\Foo
{
    public function doFoo($foo) : void
    {
    }
}
