<?php

namespace _PhpScoper88fe6e0ad041\Bug2600;

use function PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param mixed ...$x
     */
    public function doFoo($x = null)
    {
        $args = \func_get_args();
        \PHPStan\Analyser\assertType('mixed', $x);
        \PHPStan\Analyser\assertType('array', $args);
    }
    /**
     * @param mixed ...$x
     */
    public function doBar($x = null)
    {
        \PHPStan\Analyser\assertType('mixed', $x);
    }
    /**
     * @param mixed $x
     */
    public function doBaz(...$x)
    {
        \PHPStan\Analyser\assertType('array<int, mixed>', $x);
    }
    /**
     * @param mixed ...$x
     */
    public function doLorem(...$x)
    {
        \PHPStan\Analyser\assertType('array<int, mixed>', $x);
    }
    public function doIpsum($x = null)
    {
        $args = \func_get_args();
        \PHPStan\Analyser\assertType('mixed', $x);
        \PHPStan\Analyser\assertType('array', $args);
    }
}
class Bar
{
    /**
     * @param string ...$x
     */
    public function doFoo($x = null)
    {
        $args = \func_get_args();
        \PHPStan\Analyser\assertType('string|null', $x);
        \PHPStan\Analyser\assertType('array', $args);
    }
    /**
     * @param string ...$x
     */
    public function doBar($x = null)
    {
        \PHPStan\Analyser\assertType('string|null', $x);
    }
    /**
     * @param string $x
     */
    public function doBaz(...$x)
    {
        \PHPStan\Analyser\assertType('array<int, string>', $x);
    }
    /**
     * @param string ...$x
     */
    public function doLorem(...$x)
    {
        \PHPStan\Analyser\assertType('array<int, string>', $x);
    }
}
function foo($x, string ...$y) : void
{
    \PHPStan\Analyser\assertType('mixed', $x);
    \PHPStan\Analyser\assertType('array<int, string>', $y);
}
function ($x, string ...$y) : void {
    \PHPStan\Analyser\assertType('mixed', $x);
    \PHPStan\Analyser\assertType('array<int, string>', $y);
};
