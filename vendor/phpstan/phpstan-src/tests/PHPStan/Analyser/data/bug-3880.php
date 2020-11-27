<?php

namespace _PhpScopera143bcca66cb\Bug3880;

use function PHPStan\Analyser\assertType;
function ($value) : void {
    $num = (float) $value;
    if (!\is_numeric($value) && !\is_bool($value) || $num > 9223372036854775807 || $num < -9.223372036854776E+18) {
        \PHPStan\Analyser\assertType('mixed', $value);
    }
};
