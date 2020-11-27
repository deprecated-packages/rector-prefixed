<?php

namespace _PhpScopera143bcca66cb\IntersectionStatic;

use function PHPStan\Analyser\assertType;
interface Foo
{
    /**
     * @return static
     */
    public function returnStatic() : self;
}
interface Bar
{
}
interface Baz
{
    /**
     * @return static
     */
    public function returnStatic() : self;
}
class Lorem
{
    /**
     * @param Foo&Bar $intersection
     */
    public function doFoo($intersection)
    {
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\IntersectionStatic\\Bar&IntersectionStatic\\Foo', $intersection);
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\IntersectionStatic\\Bar&IntersectionStatic\\Foo', $intersection->returnStatic());
    }
    /**
     * @param Foo&Baz $intersection
     */
    public function doBar($intersection)
    {
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\IntersectionStatic\\Baz&IntersectionStatic\\Foo', $intersection);
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\IntersectionStatic\\Baz&IntersectionStatic\\Foo', $intersection->returnStatic());
    }
}
