<?php

namespace _PhpScoper26e51eeacccf\CheckTypeFunctionCallNotPhpDoc;

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
