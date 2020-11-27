<?php

namespace _PhpScopera143bcca66cb\Bug3993;

use function PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo($arguments)
    {
        if (!isset($arguments) || \count($arguments) === 0) {
            return;
        }
        \PHPStan\Analyser\assertType('mixed~null', $arguments);
        \array_shift($arguments);
        \PHPStan\Analyser\assertType('mixed~null', $arguments);
        \PHPStan\Analyser\assertType('int<0, max>', \count($arguments));
    }
}
