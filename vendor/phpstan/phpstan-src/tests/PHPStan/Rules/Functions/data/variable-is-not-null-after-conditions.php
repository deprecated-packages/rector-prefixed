<?php

namespace _PhpScoperbd5d0c5f7638\VariableIsNotNullAfterConditions;

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
