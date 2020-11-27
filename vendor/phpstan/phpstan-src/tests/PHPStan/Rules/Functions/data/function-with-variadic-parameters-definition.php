<?php

namespace _PhpScopera143bcca66cb\FunctionWithVariadicParameters;

function foo($bar, int ...$foo)
{
}
function bar($foo)
{
    $bar = \func_get_args();
}
