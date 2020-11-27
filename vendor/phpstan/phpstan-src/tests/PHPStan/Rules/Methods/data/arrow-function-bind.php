<?php

// lint >= 7.4
namespace _PhpScopera143bcca66cb\CallArrowFunctionBind;

class Foo
{
    private function privateMethod()
    {
    }
    public function publicMethod()
    {
    }
}
class Bar
{
    public function fooMethod() : \_PhpScopera143bcca66cb\CallArrowFunctionBind\Foo
    {
        \Closure::bind(fn(\_PhpScopera143bcca66cb\CallArrowFunctionBind\Foo $foo) => $foo->privateMethod(), null, \_PhpScopera143bcca66cb\CallArrowFunctionBind\Foo::class);
        \Closure::bind(fn(\_PhpScopera143bcca66cb\CallArrowFunctionBind\Foo $foo) => $foo->nonexistentMethod(), null, \_PhpScopera143bcca66cb\CallArrowFunctionBind\Foo::class);
        \Closure::bind(fn() => $this->fooMethod(), $nonexistent, self::class);
        \Closure::bind(fn() => $this->barMethod(), $nonexistent, self::class);
        \Closure::bind(fn(\_PhpScopera143bcca66cb\CallArrowFunctionBind\Foo $foo) => $foo->privateMethod(), null, '_PhpScopera143bcca66cb\\CallArrowFunctionBind\\Foo');
        \Closure::bind(fn(\_PhpScopera143bcca66cb\CallArrowFunctionBind\Foo $foo) => $foo->nonexistentMethod(), null, '_PhpScopera143bcca66cb\\CallArrowFunctionBind\\Foo');
        \Closure::bind(fn(\_PhpScopera143bcca66cb\CallArrowFunctionBind\Foo $foo) => $foo->privateMethod(), null, new \_PhpScopera143bcca66cb\CallArrowFunctionBind\Foo());
        \Closure::bind(fn(\_PhpScopera143bcca66cb\CallArrowFunctionBind\Foo $foo) => $foo->nonexistentMethod(), null, new \_PhpScopera143bcca66cb\CallArrowFunctionBind\Foo());
        \Closure::bind(fn() => $this->privateMethod(), $this->fooMethod(), \_PhpScopera143bcca66cb\CallArrowFunctionBind\Foo::class);
        \Closure::bind(fn() => $this->nonexistentMethod(), $this->fooMethod(), \_PhpScopera143bcca66cb\CallArrowFunctionBind\Foo::class);
        (fn() => $this->publicMethod())->call(new \_PhpScopera143bcca66cb\CallArrowFunctionBind\Foo());
    }
}
