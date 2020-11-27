<?php

namespace _PhpScoper26e51eeacccf\FunctionCallStatementNoSideEffects;

class Foo
{
    public function doFoo()
    {
        \printf('%s', 'test');
        \sprintf('%s', 'test');
    }
}
