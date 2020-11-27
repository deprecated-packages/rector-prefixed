<?php

namespace _PhpScoperbd5d0c5f7638\IntersectionStatic;

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
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\IntersectionStatic\\Bar&IntersectionStatic\\Foo', $intersection);
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\IntersectionStatic\\Bar&IntersectionStatic\\Foo', $intersection->returnStatic());
    }
    /**
     * @param Foo&Baz $intersection
     */
    public function doBar($intersection)
    {
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\IntersectionStatic\\Baz&IntersectionStatic\\Foo', $intersection);
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\IntersectionStatic\\Baz&IntersectionStatic\\Foo', $intersection->returnStatic());
    }
}
