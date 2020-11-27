<?php

namespace _PhpScoperbd5d0c5f7638\ParameterTypeWidening;

class Foo
{
    public function doFoo(string $foo) : void
    {
    }
}
class Bar extends \_PhpScoperbd5d0c5f7638\ParameterTypeWidening\Foo
{
    public function doFoo($foo) : void
    {
    }
}
