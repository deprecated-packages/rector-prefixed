<?php

namespace _PhpScoperabd03f0baf05\ArraySlice;

use function PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param non-empty-array $a
     */
    public function nonEmpty(array $a) : void
    {
        \PHPStan\Analyser\assertType('array', \array_slice($a, 1));
    }
    /**
     * @param mixed $arr
     */
    public function fromMixed($arr) : void
    {
        \PHPStan\Analyser\assertType('array', \array_slice($arr, 1, 2));
    }
    /**
     * @param array<int, bool> $arr1
     * @param array<string, int> $arr2
     */
    public function preserveTypes(array $arr1, array $arr2) : void
    {
        \PHPStan\Analyser\assertType('array<int, bool>', \array_slice($arr1, 1, 2));
        \PHPStan\Analyser\assertType('array<int, bool>', \array_slice($arr1, 1, 2, \true));
        \PHPStan\Analyser\assertType('array<string, int>', \array_slice($arr2, 1, 2));
        \PHPStan\Analyser\assertType('array<string, int>', \array_slice($arr2, 1, 2, \true));
    }
}
