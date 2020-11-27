<?php

// lint >= 7.4
namespace _PhpScoper26e51eeacccf\CallArrowFunctionBind;

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
    public function fooMethod() : \_PhpScoper26e51eeacccf\CallArrowFunctionBind\Foo
    {
        \Closure::bind(fn(\_PhpScoper26e51eeacccf\CallArrowFunctionBind\Foo $foo) => $foo->privateMethod(), null, \_PhpScoper26e51eeacccf\CallArrowFunctionBind\Foo::class);
        \Closure::bind(fn(\_PhpScoper26e51eeacccf\CallArrowFunctionBind\Foo $foo) => $foo->nonexistentMethod(), null, \_PhpScoper26e51eeacccf\CallArrowFunctionBind\Foo::class);
        \Closure::bind(fn() => $this->fooMethod(), $nonexistent, self::class);
        \Closure::bind(fn() => $this->barMethod(), $nonexistent, self::class);
        \Closure::bind(fn(\_PhpScoper26e51eeacccf\CallArrowFunctionBind\Foo $foo) => $foo->privateMethod(), null, '_PhpScoper26e51eeacccf\\CallArrowFunctionBind\\Foo');
        \Closure::bind(fn(\_PhpScoper26e51eeacccf\CallArrowFunctionBind\Foo $foo) => $foo->nonexistentMethod(), null, '_PhpScoper26e51eeacccf\\CallArrowFunctionBind\\Foo');
        \Closure::bind(fn(\_PhpScoper26e51eeacccf\CallArrowFunctionBind\Foo $foo) => $foo->privateMethod(), null, new \_PhpScoper26e51eeacccf\CallArrowFunctionBind\Foo());
        \Closure::bind(fn(\_PhpScoper26e51eeacccf\CallArrowFunctionBind\Foo $foo) => $foo->nonexistentMethod(), null, new \_PhpScoper26e51eeacccf\CallArrowFunctionBind\Foo());
        \Closure::bind(fn() => $this->privateMethod(), $this->fooMethod(), \_PhpScoper26e51eeacccf\CallArrowFunctionBind\Foo::class);
        \Closure::bind(fn() => $this->nonexistentMethod(), $this->fooMethod(), \_PhpScoper26e51eeacccf\CallArrowFunctionBind\Foo::class);
        (fn() => $this->publicMethod())->call(new \_PhpScoper26e51eeacccf\CallArrowFunctionBind\Foo());
    }
}
