<?php

namespace _PhpScoper006a73f0e455\ImpossibleStaticMethodCallNotPhpDoc;

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
