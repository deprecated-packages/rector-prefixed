<?php

namespace _PhpScoper006a73f0e455;

$alwaysDefinedNotNullable = 'string';
if (\_PhpScoper006a73f0e455\doFoo()) {
    $sometimesDefinedVariable = 1;
}
if (isset($alwaysDefinedNotNullable, $sometimesDefinedVariable, $neverDefinedVariable)) {
}
