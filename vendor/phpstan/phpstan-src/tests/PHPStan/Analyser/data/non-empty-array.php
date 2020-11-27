<?php

namespace _PhpScoper88fe6e0ad041\NonEmptyArray;

use function PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param non-empty-array $array
     * @param non-empty-list $list
     * @param non-empty-array<int, string> $arrayOfStrings
     * @param non-empty-list<\stdClass> $listOfStd
     * @param non-empty-list<\stdClass> $listOfStd2
     * @param non-empty-list<string, \stdClass> $invalidList
     */
    public function doFoo(array $array, array $list, array $arrayOfStrings, array $listOfStd, $listOfStd2, array $invalidList, $invalidList2) : void
    {
        \PHPStan\Analyser\assertType('array&nonEmpty', $array);
        \PHPStan\Analyser\assertType('array<int, mixed>&nonEmpty', $list);
        \PHPStan\Analyser\assertType('array<int, string>&nonEmpty', $arrayOfStrings);
        \PHPStan\Analyser\assertType('array<int, stdClass>&nonEmpty', $listOfStd);
        \PHPStan\Analyser\assertType('array<int, stdClass>&nonEmpty', $listOfStd2);
        \PHPStan\Analyser\assertType('array', $invalidList);
        \PHPStan\Analyser\assertType('mixed', $invalidList2);
    }
}
