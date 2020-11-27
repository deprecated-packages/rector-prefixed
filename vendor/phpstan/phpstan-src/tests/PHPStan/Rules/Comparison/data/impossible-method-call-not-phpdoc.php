<?php

namespace _PhpScoper006a73f0e455\ImpossibleMethodCallNotPhpDoc;

class Foo
{
    /**
     * @param string $phpDocString
     */
    public function doFoo(string $realString, $phpDocString)
    {
        $assertion = new \PHPStan\Tests\AssertionClass();
        $assertion->assertString($realString);
        $assertion->assertString($phpDocString);
        $assertion->assertString($phpDocString);
    }
}
