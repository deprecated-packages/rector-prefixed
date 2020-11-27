<?php

namespace _PhpScoper26e51eeacccf\Bug4016;

use function PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param array<int, int> $a
     */
    public function doFoo(array $a) : void
    {
        \PHPStan\Analyser\assertType('array<int, int>', $a);
        $a[] = 2;
        \PHPStan\Analyser\assertType('array<int, int>&nonEmpty', $a);
        unset($a[0]);
        \PHPStan\Analyser\assertType('array<int, int>', $a);
    }
    /**
     * @param array<int, int> $a
     */
    public function doBar(array $a) : void
    {
        \PHPStan\Analyser\assertType('array<int, int>', $a);
        $a[1] = 2;
        \PHPStan\Analyser\assertType('array<int, int>&nonEmpty', $a);
        unset($a[1]);
        \PHPStan\Analyser\assertType('array<int, int>', $a);
    }
}
