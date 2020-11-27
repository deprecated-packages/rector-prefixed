<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\UnpackOperator;

class Foo
{
    /**
     * @param string[] $strings
     */
    public function doFoo(array $strings)
    {
        $constantArray = ['foo', 'bar', 'baz'];
        \sprintf('%s', ...$strings);
        \sprintf('%s', ...$constantArray);
        \sprintf('%s', $strings);
        \sprintf('%s', $constantArray);
        \sprintf(...$strings);
        \sprintf(...$constantArray);
        \sprintf('%s', new \_PhpScopera143bcca66cb\UnpackOperator\Foo());
        \sprintf('%s', new \_PhpScopera143bcca66cb\UnpackOperator\Bar());
        \printf('%s', new \_PhpScopera143bcca66cb\UnpackOperator\Foo());
        \printf('%s', new \_PhpScopera143bcca66cb\UnpackOperator\Bar());
    }
}
class Bar
{
    public function __toString()
    {
    }
}
