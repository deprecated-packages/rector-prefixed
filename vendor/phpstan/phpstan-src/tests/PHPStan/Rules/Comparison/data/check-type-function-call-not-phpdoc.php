<?php

namespace _PhpScopera143bcca66cb\CheckTypeFunctionCallNotPhpDoc;

class Foo
{
    /**
     * @param int $phpDocInteger
     */
    public function doFoo(int $realInteger, $phpDocInteger)
    {
        if (\is_int($realInteger)) {
        }
        if (\is_int($phpDocInteger)) {
        }
    }
}
