<?php

namespace _PhpScoper006a73f0e455\CheckTypeFunctionCallNotPhpDoc;

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
