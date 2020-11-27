<?php

namespace _PhpScoper006a73f0e455\CatchWithoutVariable;

use function PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo() : void
    {
        try {
        } catch (\_PhpScoper006a73f0e455\FooException) {
            \PHPStan\Analyser\assertType('*ERROR*', $e);
        }
    }
}
