<?php

namespace _PhpScoper006a73f0e455\VariableIsNotNullAfterConditions;

/**
 * @return string|null
 */
function stringOrNull()
{
}
function foo(string $foo)
{
}
function () {
    if ($bar) {
        $class = (string) stringOrNull();
    } elseif ($baz) {
        $class = stringOrNull();
        if ($class === null) {
            return [];
        }
    } else {
        return [];
    }
    foo($class);
};
