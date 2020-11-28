<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Levels\Echo_;

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
        echo $array, $arrayOrCallable, $arrayOrFloatOrInt, $arrayOrString;
    }
}
