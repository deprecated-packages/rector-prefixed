<?php

namespace _PhpScoperabd03f0baf05\ImpossibleMethodCallNotPhpDoc;

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
