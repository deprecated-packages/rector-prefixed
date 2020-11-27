<?php

namespace _PhpScoper88fe6e0ad041\CatchWithoutVariable;

use function PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo() : void
    {
        try {
        } catch (\_PhpScoper88fe6e0ad041\FooException) {
            \PHPStan\Analyser\assertType('*ERROR*', $e);
        }
    }
}
