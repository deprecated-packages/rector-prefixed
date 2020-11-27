<?php

// lint >= 8.0
namespace _PhpScopera143bcca66cb\NativeStaticReturnType;

use function PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo() : \_PhpScopera143bcca66cb\static
    {
        return new static();
    }
    public function doBar() : void
    {
        \PHPStan\Analyser\assertType('static(NativeStaticReturnType\\Foo)', $this->doFoo());
    }
    /**
     * @return callable(): static
     */
    public function doBaz() : callable
    {
        $f = function () : static {
            return new static();
        };
        \PHPStan\Analyser\assertType('static(NativeStaticReturnType\\Foo)', $f());
        return $f;
    }
}
class Bar extends \_PhpScopera143bcca66cb\NativeStaticReturnType\Foo
{
}
function (\_PhpScopera143bcca66cb\NativeStaticReturnType\Foo $foo) : void {
    \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\NativeStaticReturnType\\Foo', $foo->doFoo());
    $callable = $foo->doBaz();
    \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\callable(): NativeStaticReturnType\\Foo', $callable);
    \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\NativeStaticReturnType\\Foo', $callable());
};
function (\_PhpScopera143bcca66cb\NativeStaticReturnType\Bar $bar) : void {
    \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\NativeStaticReturnType\\Bar', $bar->doFoo());
    $callable = $bar->doBaz();
    \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\callable(): NativeStaticReturnType\\Bar', $callable);
    \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\NativeStaticReturnType\\Bar', $callable());
};
