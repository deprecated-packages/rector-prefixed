<?php

namespace _PhpScoper26e51eeacccf\CallClosureBind;

class Bar
{
    public function fooMethod() : \_PhpScoper26e51eeacccf\CallClosureBind\Foo
    {
        \Closure::bind(function (\_PhpScoper26e51eeacccf\CallClosureBind\Foo $foo) {
            $foo->privateMethod();
            $foo->nonexistentMethod();
        }, null, \_PhpScoper26e51eeacccf\CallClosureBind\Foo::class);
        $this->fooMethod();
        $this->barMethod();
        $foo = new \_PhpScoper26e51eeacccf\CallClosureBind\Foo();
        $foo->privateMethod();
        $foo->nonexistentMethod();
        \Closure::bind(function () {
            $this->fooMethod();
            $this->barMethod();
        }, $nonexistent, self::class);
        \Closure::bind(function (\_PhpScoper26e51eeacccf\CallClosureBind\Foo $foo) {
            $foo->privateMethod();
            $foo->nonexistentMethod();
        }, null, '_PhpScoper26e51eeacccf\\CallClosureBind\\Foo');
        \Closure::bind(function (\_PhpScoper26e51eeacccf\CallClosureBind\Foo $foo) {
            $foo->privateMethod();
            $foo->nonexistentMethod();
        }, null, new \_PhpScoper26e51eeacccf\CallClosureBind\Foo());
        \Closure::bind(function () {
            // $this is Foo
            $this->privateMethod();
            $this->nonexistentMethod();
        }, $this->fooMethod(), \_PhpScoper26e51eeacccf\CallClosureBind\Foo::class);
        (function () {
            $this->publicMethod();
        })->call(new \_PhpScoper26e51eeacccf\CallClosureBind\Foo());
    }
}
