<?php

namespace _PhpScoperbd5d0c5f7638;

$alwaysDefinedNotNullable = 'string';
if (\_PhpScoperbd5d0c5f7638\doFoo()) {
    $sometimesDefinedVariable = 1;
}
if (isset($alwaysDefinedNotNullable, $sometimesDefinedVariable, $neverDefinedVariable)) {
}
