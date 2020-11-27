<?php

// lint >= 8.0
namespace _PhpScoper006a73f0e455\NativeUnionTypesSupport;

function foo(int|bool $foo) : int|bool
{
    return 1;
}
function bar() : int|bool
{
}
function (int|bool $foo) : int|bool {
};
function () : int|bool {
};
fn(int|bool $foo): int|bool => 1;
fn(): int|bool => 1;
