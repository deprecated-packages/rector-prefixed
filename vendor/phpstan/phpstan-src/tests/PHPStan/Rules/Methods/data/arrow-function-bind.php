<?php

// lint >= 7.4
namespace _PhpScoperbd5d0c5f7638\CallArrowFunctionBind;

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
    public function fooMethod() : \_PhpScoperbd5d0c5f7638\CallArrowFunctionBind\Foo
    {
        \Closure::bind(fn(\_PhpScoperbd5d0c5f7638\CallArrowFunctionBind\Foo $foo) => $foo->privateMethod(), null, \_PhpScoperbd5d0c5f7638\CallArrowFunctionBind\Foo::class);
        \Closure::bind(fn(\_PhpScoperbd5d0c5f7638\CallArrowFunctionBind\Foo $foo) => $foo->nonexistentMethod(), null, \_PhpScoperbd5d0c5f7638\CallArrowFunctionBind\Foo::class);
        \Closure::bind(fn() => $this->fooMethod(), $nonexistent, self::class);
        \Closure::bind(fn() => $this->barMethod(), $nonexistent, self::class);
        \Closure::bind(fn(\_PhpScoperbd5d0c5f7638\CallArrowFunctionBind\Foo $foo) => $foo->privateMethod(), null, '_PhpScoperbd5d0c5f7638\\CallArrowFunctionBind\\Foo');
        \Closure::bind(fn(\_PhpScoperbd5d0c5f7638\CallArrowFunctionBind\Foo $foo) => $foo->nonexistentMethod(), null, '_PhpScoperbd5d0c5f7638\\CallArrowFunctionBind\\Foo');
        \Closure::bind(fn(\_PhpScoperbd5d0c5f7638\CallArrowFunctionBind\Foo $foo) => $foo->privateMethod(), null, new \_PhpScoperbd5d0c5f7638\CallArrowFunctionBind\Foo());
        \Closure::bind(fn(\_PhpScoperbd5d0c5f7638\CallArrowFunctionBind\Foo $foo) => $foo->nonexistentMethod(), null, new \_PhpScoperbd5d0c5f7638\CallArrowFunctionBind\Foo());
        \Closure::bind(fn() => $this->privateMethod(), $this->fooMethod(), \_PhpScoperbd5d0c5f7638\CallArrowFunctionBind\Foo::class);
        \Closure::bind(fn() => $this->nonexistentMethod(), $this->fooMethod(), \_PhpScoperbd5d0c5f7638\CallArrowFunctionBind\Foo::class);
        (fn() => $this->publicMethod())->call(new \_PhpScoperbd5d0c5f7638\CallArrowFunctionBind\Foo());
    }
}
