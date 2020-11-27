<?php

namespace _PhpScoper006a73f0e455\PowFunction;

use function PHPStan\Analyser\assertType;
function ($a, $b) : void {
    \PHPStan\Analyser\assertType('(float|int)', \pow($a, $b));
};
function (int $a, int $b) : void {
    \PHPStan\Analyser\assertType('(float|int)', \pow($a, $b));
};
function (\GMP $a, \GMP $b) : void {
    \PHPStan\Analyser\assertType('GMP', \pow($a, $b));
};
function (\stdClass $a, \GMP $b) : void {
    \PHPStan\Analyser\assertType('GMP|stdClass', \pow($a, $b));
};
