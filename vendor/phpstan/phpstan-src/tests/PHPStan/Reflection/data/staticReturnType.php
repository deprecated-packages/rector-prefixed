<?php

// lint >= 8.0
namespace _PhpScoper006a73f0e455\NativeStaticReturnType;

use function PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo() : \_PhpScoper006a73f0e455\static
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
class Bar extends \_PhpScoper006a73f0e455\NativeStaticReturnType\Foo
{
}
function (\_PhpScoper006a73f0e455\NativeStaticReturnType\Foo $foo) : void {
    \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\NativeStaticReturnType\\Foo', $foo->doFoo());
    $callable = $foo->doBaz();
    \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\callable(): NativeStaticReturnType\\Foo', $callable);
    \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\NativeStaticReturnType\\Foo', $callable());
};
function (\_PhpScoper006a73f0e455\NativeStaticReturnType\Bar $bar) : void {
    \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\NativeStaticReturnType\\Bar', $bar->doFoo());
    $callable = $bar->doBaz();
    \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\callable(): NativeStaticReturnType\\Bar', $callable);
    \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\NativeStaticReturnType\\Bar', $callable());
};
