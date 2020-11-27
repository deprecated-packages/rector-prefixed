<?php

namespace _PhpScoperbd5d0c5f7638;

use function PHPStan\Analyser\assertType;
function (int $min) {
    \assert($min === 10 || $min === 15);
    \PHPStan\Analyser\assertType('int<10, 20>', \random_int($min, 20));
};
function (int $min) {
    \assert($min <= 0);
    \PHPStan\Analyser\assertType('int<min, 20>', \random_int($min, 20));
};
function (int $max) {
    \assert($min >= 0);
    \PHPStan\Analyser\assertType('int<0, max>', \random_int(0, $max));
};
function (int $i) {
    \PHPStan\Analyser\assertType('int', \random_int($i, $i));
};
\PHPStan\Analyser\assertType('0', \random_int(0, 0));
\PHPStan\Analyser\assertType('int', \random_int(\PHP_INT_MIN, \PHP_INT_MAX));
\PHPStan\Analyser\assertType('int<0, max>', \random_int(0, \PHP_INT_MAX));
\PHPStan\Analyser\assertType('int<min, 0>', \random_int(\PHP_INT_MIN, 0));
\PHPStan\Analyser\assertType('int<-1, 1>', \random_int(-1, 1));
\PHPStan\Analyser\assertType('int<0, 30>', \random_int(0, \random_int(0, 30)));
\PHPStan\Analyser\assertType('int<0, 100>', \random_int(\random_int(0, 10), 100));
\PHPStan\Analyser\assertType('*NEVER*', \random_int(10, 1));
\PHPStan\Analyser\assertType('*NEVER*', \random_int(2, \random_int(0, 1)));
\PHPStan\Analyser\assertType('int<0, 1>', \random_int(0, \random_int(0, 1)));
\PHPStan\Analyser\assertType('*NEVER*', \random_int(\random_int(0, 1), -1));
\PHPStan\Analyser\assertType('int<0, 1>', \random_int(\random_int(0, 1), 1));
\PHPStan\Analyser\assertType('int<-5, 5>', \random_int(\random_int(-5, 0), \random_int(0, 5)));
\PHPStan\Analyser\assertType('int', \random_int(\random_int(\PHP_INT_MIN, 0), \random_int(0, \PHP_INT_MAX)));
