<?php

namespace _PhpScoper88fe6e0ad041;

$alwaysDefinedNotNullable = 'string';
if (\_PhpScoper88fe6e0ad041\doFoo()) {
    $sometimesDefinedVariable = 1;
}
if (isset($alwaysDefinedNotNullable, $sometimesDefinedVariable, $neverDefinedVariable)) {
}
