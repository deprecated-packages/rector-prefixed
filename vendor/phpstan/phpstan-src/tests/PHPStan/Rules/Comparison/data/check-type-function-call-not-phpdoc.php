<?php

namespace _PhpScoperbd5d0c5f7638\CheckTypeFunctionCallNotPhpDoc;

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
