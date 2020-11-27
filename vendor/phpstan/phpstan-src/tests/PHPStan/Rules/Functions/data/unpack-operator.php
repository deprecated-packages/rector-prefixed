<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\UnpackOperator;

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
        \sprintf('%s', new \_PhpScoper26e51eeacccf\UnpackOperator\Foo());
        \sprintf('%s', new \_PhpScoper26e51eeacccf\UnpackOperator\Bar());
        \printf('%s', new \_PhpScoper26e51eeacccf\UnpackOperator\Foo());
        \printf('%s', new \_PhpScoper26e51eeacccf\UnpackOperator\Bar());
    }
}
class Bar
{
    public function __toString()
    {
    }
}
