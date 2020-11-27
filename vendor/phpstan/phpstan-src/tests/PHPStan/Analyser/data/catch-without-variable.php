<?php

namespace _PhpScoperbd5d0c5f7638\CatchWithoutVariable;

use function PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo() : void
    {
        try {
        } catch (\_PhpScoperbd5d0c5f7638\FooException) {
            \PHPStan\Analyser\assertType('*ERROR*', $e);
        }
    }
}
