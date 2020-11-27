<?php

namespace _PhpScopera143bcca66cb\CallClosureBind;

class Bar
{
    public function fooMethod() : \_PhpScopera143bcca66cb\CallClosureBind\Foo
    {
        \Closure::bind(function (\_PhpScopera143bcca66cb\CallClosureBind\Foo $foo) {
            $foo->privateMethod();
            $foo->nonexistentMethod();
        }, null, \_PhpScopera143bcca66cb\CallClosureBind\Foo::class);
        $this->fooMethod();
        $this->barMethod();
        $foo = new \_PhpScopera143bcca66cb\CallClosureBind\Foo();
        $foo->privateMethod();
        $foo->nonexistentMethod();
        \Closure::bind(function () {
            $this->fooMethod();
            $this->barMethod();
        }, $nonexistent, self::class);
        \Closure::bind(function (\_PhpScopera143bcca66cb\CallClosureBind\Foo $foo) {
            $foo->privateMethod();
            $foo->nonexistentMethod();
        }, null, '_PhpScopera143bcca66cb\\CallClosureBind\\Foo');
        \Closure::bind(function (\_PhpScopera143bcca66cb\CallClosureBind\Foo $foo) {
            $foo->privateMethod();
            $foo->nonexistentMethod();
        }, null, new \_PhpScopera143bcca66cb\CallClosureBind\Foo());
        \Closure::bind(function () {
            // $this is Foo
            $this->privateMethod();
            $this->nonexistentMethod();
        }, $this->fooMethod(), \_PhpScopera143bcca66cb\CallClosureBind\Foo::class);
        (function () {
            $this->publicMethod();
        })->call(new \_PhpScopera143bcca66cb\CallClosureBind\Foo());
    }
}
