<?php

namespace _PhpScoper88fe6e0ad041\UnresolvableTypes;

/**
 * @param array<int, int, int> $arrayWithTooManyArgs
 * @param iterable<int, int, int> $iterableWithTooManyArgs
 * @param \Foo<int> $genericFoo
 */
function test($arrayWithTooManyArgs, $iterableWithTooManyArgs, $genericFoo)
{
    die;
}
