<?php

namespace _PhpScoperbd5d0c5f7638\ImpossibleMethodCallNotPhpDoc;

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
