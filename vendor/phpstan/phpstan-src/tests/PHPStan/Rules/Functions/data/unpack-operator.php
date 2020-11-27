<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\UnpackOperator;

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
        \sprintf('%s', new \_PhpScoper88fe6e0ad041\UnpackOperator\Foo());
        \sprintf('%s', new \_PhpScoper88fe6e0ad041\UnpackOperator\Bar());
        \printf('%s', new \_PhpScoper88fe6e0ad041\UnpackOperator\Foo());
        \printf('%s', new \_PhpScoper88fe6e0ad041\UnpackOperator\Bar());
    }
}
class Bar
{
    public function __toString()
    {
    }
}
