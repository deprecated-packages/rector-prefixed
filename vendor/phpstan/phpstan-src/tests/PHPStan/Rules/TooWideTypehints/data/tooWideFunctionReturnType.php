<?php

namespace _PhpScoperbd5d0c5f7638\TooWideFunctionReturnType;

function foo() : \Generator
{
    (yield 1);
    (yield 2);
    return 3;
}
function bar() : ?string
{
    return null;
}
function baz() : ?string
{
    return 'foo';
}
function lorem() : ?string
{
    if (\rand(0, 1)) {
        return '1';
    }
    return null;
}
