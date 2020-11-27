<?php

namespace _PhpScoperbd5d0c5f7638\ArrowFunctionReturnTypeInference;

use function PHPStan\Analyser\assertType;
function (int $i) : void {
    $fn = fn() => $i;
    \PHPStan\Analyser\assertType('int', $fn());
};
function (int $i) : void {
    $fn = fn(): string => $i;
    \PHPStan\Analyser\assertType('string', $fn());
};
