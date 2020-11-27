<?php

namespace _PhpScoper006a73f0e455\FunctionWithVariadicParameters;

function foo($bar, int ...$foo)
{
}
function bar($foo)
{
    $bar = \func_get_args();
}
