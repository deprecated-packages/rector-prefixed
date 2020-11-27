<?php

namespace _PhpScoper88fe6e0ad041\ArrowFunctionReturnTypeInference;

use function PHPStan\Analyser\assertType;
function (int $i) : void {
    $fn = fn() => $i;
    \PHPStan\Analyser\assertType('int', $fn());
};
function (int $i) : void {
    $fn = fn(): string => $i;
    \PHPStan\Analyser\assertType('string', $fn());
};
