<?php

namespace _PhpScoper88fe6e0ad041\ShadowedTraitMethods;

use function PHPStan\Analyser\assertType;
trait FooTrait
{
    public function doFoo()
    {
        $a = 1;
        \PHPStan\Analyser\assertType('foo', $a);
        // doesn't get evaluated
    }
}
trait BarTrait
{
    use FooTrait;
    public function doFoo()
    {
        $a = 2;
        \PHPStan\Analyser\assertType('2', $a);
    }
}
class Foo
{
    use BarTrait;
}
