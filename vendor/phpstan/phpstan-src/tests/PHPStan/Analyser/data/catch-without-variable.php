<?php

namespace _PhpScoperabd03f0baf05\CatchWithoutVariable;

use function PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo() : void
    {
        try {
        } catch (\_PhpScoperabd03f0baf05\FooException) {
            \PHPStan\Analyser\assertType('*ERROR*', $e);
        }
    }
}
