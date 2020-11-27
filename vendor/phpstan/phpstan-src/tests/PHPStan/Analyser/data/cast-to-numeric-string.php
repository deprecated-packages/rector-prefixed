<?php

namespace _PhpScoper88fe6e0ad041\CastToNumericString;

use function PHPStan\Analyser\assertType;
/**
 * @param int|float|numeric-string $numeric
 * @param numeric $numeric2
 * @param number $number
 * @param positive-int $positive
 * @param negative-int $negative
 * @param 1 $constantInt
 */
function foo(int $a, float $b, $numeric, $numeric2, $number, $positive, $negative, $constantInt) : void
{
    \PHPStan\Analyser\assertType('string&numeric', (string) $a);
    \PHPStan\Analyser\assertType('string&numeric', (string) $b);
    \PHPStan\Analyser\assertType('string&numeric', (string) $numeric);
    \PHPStan\Analyser\assertType('string&numeric', (string) $numeric2);
    \PHPStan\Analyser\assertType('string&numeric', (string) $number);
    \PHPStan\Analyser\assertType('string&numeric', (string) $positive);
    \PHPStan\Analyser\assertType('string&numeric', (string) $negative);
    \PHPStan\Analyser\assertType("'1'", (string) $constantInt);
}
