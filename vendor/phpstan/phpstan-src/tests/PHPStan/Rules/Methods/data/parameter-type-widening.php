<?php

namespace _PhpScoperabd03f0baf05\ParameterTypeWidening;

class Foo
{
    public function doFoo(string $foo) : void
    {
    }
}
class Bar extends \_PhpScoperabd03f0baf05\ParameterTypeWidening\Foo
{
    public function doFoo($foo) : void
    {
    }
}
