<?php

namespace _PhpScoper88fe6e0ad041\CheckTypeFunctionCallNotPhpDoc;

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
