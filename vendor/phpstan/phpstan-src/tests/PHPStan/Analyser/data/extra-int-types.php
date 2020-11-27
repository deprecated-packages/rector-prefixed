<?php

namespace _PhpScoper006a73f0e455\ExtraIntTypes;

use function PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param positive-int $positiveInt
     * @param negative-int $negativeInt
     */
    public function doFoo(int $positiveInt, int $negativeInt, string $str) : void
    {
        \PHPStan\Analyser\assertType('int<1, max>', $positiveInt);
        \PHPStan\Analyser\assertType('int<min, -1>', $negativeInt);
        \PHPStan\Analyser\assertType('false', \strpos('u', $str) === -1);
        \PHPStan\Analyser\assertType('true', \strpos('u', $str) !== -1);
    }
}
