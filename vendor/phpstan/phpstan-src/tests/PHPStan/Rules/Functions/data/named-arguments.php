<?php

namespace _PhpScoper006a73f0e455\FunctionNamedArguments;

function bar() : void
{
    foo(i: 1);
    foo(i: 1, j: 2, z: 3);
}
function baz() : void
{
    variadicFunction(...['a' => ['b', 'c']]);
    // works - userland
    \array_merge(...['a' => ['b', 'c']]);
    // doesn't work - internal
}
