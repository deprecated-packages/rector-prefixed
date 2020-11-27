<?php

namespace _PhpScoperbd5d0c5f7638\FunctionWithVariadicParameters;

function foo($bar, int ...$foo)
{
}
function bar($foo)
{
    $bar = \func_get_args();
}
