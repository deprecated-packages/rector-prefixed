<?php

namespace _PhpScoper006a73f0e455\ParameterTypeWidening;

class Foo
{
    public function doFoo(string $foo) : void
    {
    }
}
class Bar extends \_PhpScoper006a73f0e455\ParameterTypeWidening\Foo
{
    public function doFoo($foo) : void
    {
    }
}
