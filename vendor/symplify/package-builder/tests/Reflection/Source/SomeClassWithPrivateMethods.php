<?php

declare (strict_types=1);
namespace RectorPrefix20210314\Symplify\PackageBuilder\Tests\Reflection\Source;

final class SomeClassWithPrivateMethods
{
    private function getNumber() : int
    {
        return 5;
    }
    private function plus10(int $number) : int
    {
        return $number += 10;
    }
    private function multipleByTwo(int &$number) : void
    {
        $number *= 2;
    }
}
