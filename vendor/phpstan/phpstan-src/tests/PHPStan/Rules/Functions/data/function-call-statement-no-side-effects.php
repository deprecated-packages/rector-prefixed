<?php

namespace _PhpScoperabd03f0baf05\FunctionCallStatementNoSideEffects;

class Foo
{
    public function doFoo()
    {
        \printf('%s', 'test');
        \sprintf('%s', 'test');
    }
}
