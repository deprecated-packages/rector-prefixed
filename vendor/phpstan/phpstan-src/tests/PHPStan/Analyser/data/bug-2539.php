<?php

namespace _PhpScoperbd5d0c5f7638\Bug2539;

use function PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param array<int> $array
     * @param non-empty-array<int> $nonEmptyArray
     */
    public function doFoo(array $array, array $nonEmptyArray) : void
    {
        \PHPStan\Analyser\assertType('int|false', \current($array));
        \PHPStan\Analyser\assertType('int', \current($nonEmptyArray));
        \PHPStan\Analyser\assertType('false', \current([]));
        \PHPStan\Analyser\assertType('1|2|3', \current([1, 2, 3]));
        $a = [];
        if (\rand(0, 1)) {
            $a[] = 1;
        }
        \PHPStan\Analyser\assertType('1|false', \current($a));
    }
}
