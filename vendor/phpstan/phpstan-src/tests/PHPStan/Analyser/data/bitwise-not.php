<?php

namespace _PhpScoperbd5d0c5f7638\BitwiseNot;

use function PHPStan\Analyser\assertType;
/**
 * @param string|int $stringOrInt
 */
function foo(int $int, string $string, float $float, $stringOrInt) : void
{
    \PHPStan\Analyser\assertType('int', ~$int);
    \PHPStan\Analyser\assertType('string', ~$string);
    \PHPStan\Analyser\assertType('int', ~$float);
    \PHPStan\Analyser\assertType('int|string', ~$stringOrInt);
    \PHPStan\Analyser\assertType("'" . ~"abc" . "'", ~"abc");
    \PHPStan\Analyser\assertType('int', ~1);
    //result is dependent on PHP_INT_SIZE
}
