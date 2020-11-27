<?php

namespace _PhpScoper006a73f0e455\CallClosureBind;

class Bar
{
    public function fooMethod() : \_PhpScoper006a73f0e455\CallClosureBind\Foo
    {
        \Closure::bind(function (\_PhpScoper006a73f0e455\CallClosureBind\Foo $foo) {
            $foo->privateMethod();
            $foo->nonexistentMethod();
        }, null, \_PhpScoper006a73f0e455\CallClosureBind\Foo::class);
        $this->fooMethod();
        $this->barMethod();
        $foo = new \_PhpScoper006a73f0e455\CallClosureBind\Foo();
        $foo->privateMethod();
        $foo->nonexistentMethod();
        \Closure::bind(function () {
            $this->fooMethod();
            $this->barMethod();
        }, $nonexistent, self::class);
        \Closure::bind(function (\_PhpScoper006a73f0e455\CallClosureBind\Foo $foo) {
            $foo->privateMethod();
            $foo->nonexistentMethod();
        }, null, '_PhpScoper006a73f0e455\\CallClosureBind\\Foo');
        \Closure::bind(function (\_PhpScoper006a73f0e455\CallClosureBind\Foo $foo) {
            $foo->privateMethod();
            $foo->nonexistentMethod();
        }, null, new \_PhpScoper006a73f0e455\CallClosureBind\Foo());
        \Closure::bind(function () {
            // $this is Foo
            $this->privateMethod();
            $this->nonexistentMethod();
        }, $this->fooMethod(), \_PhpScoper006a73f0e455\CallClosureBind\Foo::class);
        (function () {
            $this->publicMethod();
        })->call(new \_PhpScoper006a73f0e455\CallClosureBind\Foo());
    }
}
