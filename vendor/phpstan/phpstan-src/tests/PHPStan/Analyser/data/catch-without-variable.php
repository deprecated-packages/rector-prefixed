<?php

namespace _PhpScoper26e51eeacccf\CatchWithoutVariable;

use function PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo() : void
    {
        try {
        } catch (\_PhpScoper26e51eeacccf\FooException) {
            \PHPStan\Analyser\assertType('*ERROR*', $e);
        }
    }
}
