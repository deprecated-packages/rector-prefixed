<?php

// lint >= 7.4
namespace _PhpScoperabd03f0baf05\CallArrowFunctionBind;

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
    public function fooMethod() : \_PhpScoperabd03f0baf05\CallArrowFunctionBind\Foo
    {
        \Closure::bind(fn(\_PhpScoperabd03f0baf05\CallArrowFunctionBind\Foo $foo) => $foo->privateMethod(), null, \_PhpScoperabd03f0baf05\CallArrowFunctionBind\Foo::class);
        \Closure::bind(fn(\_PhpScoperabd03f0baf05\CallArrowFunctionBind\Foo $foo) => $foo->nonexistentMethod(), null, \_PhpScoperabd03f0baf05\CallArrowFunctionBind\Foo::class);
        \Closure::bind(fn() => $this->fooMethod(), $nonexistent, self::class);
        \Closure::bind(fn() => $this->barMethod(), $nonexistent, self::class);
        \Closure::bind(fn(\_PhpScoperabd03f0baf05\CallArrowFunctionBind\Foo $foo) => $foo->privateMethod(), null, '_PhpScoperabd03f0baf05\\CallArrowFunctionBind\\Foo');
        \Closure::bind(fn(\_PhpScoperabd03f0baf05\CallArrowFunctionBind\Foo $foo) => $foo->nonexistentMethod(), null, '_PhpScoperabd03f0baf05\\CallArrowFunctionBind\\Foo');
        \Closure::bind(fn(\_PhpScoperabd03f0baf05\CallArrowFunctionBind\Foo $foo) => $foo->privateMethod(), null, new \_PhpScoperabd03f0baf05\CallArrowFunctionBind\Foo());
        \Closure::bind(fn(\_PhpScoperabd03f0baf05\CallArrowFunctionBind\Foo $foo) => $foo->nonexistentMethod(), null, new \_PhpScoperabd03f0baf05\CallArrowFunctionBind\Foo());
        \Closure::bind(fn() => $this->privateMethod(), $this->fooMethod(), \_PhpScoperabd03f0baf05\CallArrowFunctionBind\Foo::class);
        \Closure::bind(fn() => $this->nonexistentMethod(), $this->fooMethod(), \_PhpScoperabd03f0baf05\CallArrowFunctionBind\Foo::class);
        (fn() => $this->publicMethod())->call(new \_PhpScoperabd03f0baf05\CallArrowFunctionBind\Foo());
    }
}
