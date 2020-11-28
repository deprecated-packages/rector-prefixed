<?php

namespace _PhpScoperabd03f0baf05\UnresolvableTypes;

/**
 * @param array<int, int, int> $arrayWithTooManyArgs
 * @param iterable<int, int, int> $iterableWithTooManyArgs
 * @param \Foo<int> $genericFoo
 */
function test($arrayWithTooManyArgs, $iterableWithTooManyArgs, $genericFoo)
{
    die;
}
