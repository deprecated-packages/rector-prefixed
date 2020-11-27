<?php

namespace _PhpScoper26e51eeacccf\ImpossibleStaticMethodCallNotPhpDoc;

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
