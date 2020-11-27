<?php

namespace _PhpScopera143bcca66cb\ImpossibleStaticMethodCallNotPhpDoc;

class Foo
{
    /**
     * @param int $phpDocInt
     */
    public function doFoo(int $realInt, $phpDocInt)
    {
        \PHPStan\Tests\AssertionClass::assertInt($realInt);
        \PHPStan\Tests\AssertionClass::assertInt($phpDocInt);
        \PHPStan\Tests\AssertionClass::assertInt($phpDocInt);
    }
}
