<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Bug3798;

/** @param callable(int ...$params) : void $c */
function acceptsVariadicCallable(callable $c) : void
{
    $c();
    $c(1);
    $c(1, 2, 3);
}
