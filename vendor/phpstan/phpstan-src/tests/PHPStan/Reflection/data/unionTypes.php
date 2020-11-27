<?php

// lint >= 8.0
namespace _PhpScoper006a73f0e455\NativeUnionTypes;

use function PHPStan\Analyser\assertNativeType;
use function PHPStan\Analyser\assertType;
class Foo
{
    public int|bool $fooProp;
    public function doFoo(int|bool $foo) : self|Bar
    {
        \PHPStan\Analyser\assertType('bool|int', $foo);
        \PHPStan\Analyser\assertType('bool|int', $this->fooProp);
        \PHPStan\Analyser\assertNativeType('bool|int', $foo);
    }
}
class Bar
{
}
function doFoo(int|bool $foo) : Foo|Bar
{
    \PHPStan\Analyser\assertType('bool|int', $foo);
    \PHPStan\Analyser\assertNativeType('bool|int', $foo);
}
function (\_PhpScoper006a73f0e455\NativeUnionTypes\Foo $foo) : void {
    \PHPStan\Analyser\assertType('bool|int', $foo->fooProp);
    \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\NativeUnionTypes\\Bar|NativeUnionTypes\\Foo', $foo->doFoo(1));
    \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\NativeUnionTypes\\Bar|NativeUnionTypes\\Foo', doFoo(1));
};
function () : void {
    $f = function (int|bool $foo) : Foo|Bar {
        \PHPStan\Analyser\assertType('bool|int', $foo);
    };
    \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\NativeUnionTypes\\Bar|NativeUnionTypes\\Foo', $f(1));
};
class Baz
{
    public function doFoo(array|false $foo) : void
    {
        \PHPStan\Analyser\assertType('array|false', $foo);
        \PHPStan\Analyser\assertNativeType('array|false', $foo);
        \PHPStan\Analyser\assertType('array|false', $this->doBar());
    }
    public function doBar() : array|false
    {
    }
    /**
     * @param array<int, string> $foo
     */
    public function doBaz(array|false $foo) : void
    {
        \PHPStan\Analyser\assertType('array<int, string>|false', $foo);
        \PHPStan\Analyser\assertNativeType('array|false', $foo);
        \PHPStan\Analyser\assertType('array<int, string>|false', $this->doLorem());
    }
    /**
     * @return array<int, string>
     */
    public function doLorem() : array|false
    {
    }
}
