<?php

namespace _PhpScoperbd5d0c5f7638\CallClosureBind;

class Bar
{
    public function fooMethod() : \_PhpScoperbd5d0c5f7638\CallClosureBind\Foo
    {
        \Closure::bind(function (\_PhpScoperbd5d0c5f7638\CallClosureBind\Foo $foo) {
            $foo->privateMethod();
            $foo->nonexistentMethod();
        }, null, \_PhpScoperbd5d0c5f7638\CallClosureBind\Foo::class);
        $this->fooMethod();
        $this->barMethod();
        $foo = new \_PhpScoperbd5d0c5f7638\CallClosureBind\Foo();
        $foo->privateMethod();
        $foo->nonexistentMethod();
        \Closure::bind(function () {
            $this->fooMethod();
            $this->barMethod();
        }, $nonexistent, self::class);
        \Closure::bind(function (\_PhpScoperbd5d0c5f7638\CallClosureBind\Foo $foo) {
            $foo->privateMethod();
            $foo->nonexistentMethod();
        }, null, '_PhpScoperbd5d0c5f7638\\CallClosureBind\\Foo');
        \Closure::bind(function (\_PhpScoperbd5d0c5f7638\CallClosureBind\Foo $foo) {
            $foo->privateMethod();
            $foo->nonexistentMethod();
        }, null, new \_PhpScoperbd5d0c5f7638\CallClosureBind\Foo());
        \Closure::bind(function () {
            // $this is Foo
            $this->privateMethod();
            $this->nonexistentMethod();
        }, $this->fooMethod(), \_PhpScoperbd5d0c5f7638\CallClosureBind\Foo::class);
        (function () {
            $this->publicMethod();
        })->call(new \_PhpScoperbd5d0c5f7638\CallClosureBind\Foo());
    }
}
