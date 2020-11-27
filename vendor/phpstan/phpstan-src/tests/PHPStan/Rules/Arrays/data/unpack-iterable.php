<?php

// lint >= 7.4
namespace _PhpScoper006a73f0e455\UnpackIterable;

class Foo
{
    /**
     * @param int[] $integers
     * @param int[]|null $integersOrNull
     */
    public function doFoo(array $integers, ?array $integersOrNull, string $str)
    {
        $foo = [...[1, 2, 3], ...$integers, ...$integersOrNull, ...2, ...$str];
    }
}
