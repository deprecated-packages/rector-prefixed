<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Levels\Print_;

class Foo
{
    /**
     * @param mixed[] $array
     * @param mixed[]|callable $arrayOrCallable
     * @param mixed[]|float|int $arrayOrFloatOrInt
     * @param mixed[]|string $arrayOrString
     */
    public function doFoo(array $array, $arrayOrCallable, $arrayOrFloatOrInt, $arrayOrString) : void
    {
        print $array;
        print $arrayOrCallable;
        print $arrayOrFloatOrInt;
        print $arrayOrString;
    }
}
