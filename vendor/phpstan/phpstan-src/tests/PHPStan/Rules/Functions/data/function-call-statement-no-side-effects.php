<?php

namespace _PhpScopera143bcca66cb\FunctionCallStatementNoSideEffects;

class Foo
{
    public function doFoo()
    {
        \printf('%s', 'test');
        \sprintf('%s', 'test');
    }
}
