<?php

namespace _PhpScoper88fe6e0ad041\FunctionWithVariadicParameters;

function foo($bar, int ...$foo)
{
}
function bar($foo)
{
    $bar = \func_get_args();
}
