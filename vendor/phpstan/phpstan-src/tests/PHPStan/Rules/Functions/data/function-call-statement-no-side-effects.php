<?php

namespace _PhpScoper88fe6e0ad041\FunctionCallStatementNoSideEffects;

class Foo
{
    public function doFoo()
    {
        \printf('%s', 'test');
        \sprintf('%s', 'test');
    }
}
