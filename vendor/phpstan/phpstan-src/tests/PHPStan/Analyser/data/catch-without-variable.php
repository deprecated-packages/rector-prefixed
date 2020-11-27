<?php

namespace _PhpScopera143bcca66cb\CatchWithoutVariable;

use function PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo() : void
    {
        try {
        } catch (\_PhpScopera143bcca66cb\FooException) {
            \PHPStan\Analyser\assertType('*ERROR*', $e);
        }
    }
}
