<?php

namespace _PhpScopera143bcca66cb;

$alwaysDefinedNotNullable = 'string';
if (\_PhpScopera143bcca66cb\doFoo()) {
    $sometimesDefinedVariable = 1;
}
if (isset($alwaysDefinedNotNullable, $sometimesDefinedVariable, $neverDefinedVariable)) {
}
