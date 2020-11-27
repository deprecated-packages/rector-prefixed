<?php

namespace _PhpScoperbd5d0c5f7638\FunctionCallStatementNoSideEffects;

class Foo
{
    public function doFoo()
    {
        \printf('%s', 'test');
        \sprintf('%s', 'test');
    }
}
