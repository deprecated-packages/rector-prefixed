<?php

namespace _PhpScoper26e51eeacccf;

$alwaysDefinedNotNullable = 'string';
if (\_PhpScoper26e51eeacccf\doFoo()) {
    $sometimesDefinedVariable = 1;
}
if (isset($alwaysDefinedNotNullable, $sometimesDefinedVariable, $neverDefinedVariable)) {
}
