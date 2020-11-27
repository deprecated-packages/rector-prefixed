<?php

namespace _PhpScoper88fe6e0ad041\InvokeMagicInvokeMethod;

class ClassForCallable
{
    public function doFoo(callable $foo)
    {
    }
}
class ClassWithInvoke
{
    public function __invoke()
    {
    }
}
function () {
    $foo = new \_PhpScoper88fe6e0ad041\InvokeMagicInvokeMethod\ClassForCallable();
    $foo->doFoo(new \_PhpScoper88fe6e0ad041\InvokeMagicInvokeMethod\ClassWithInvoke());
    $foo->doFoo($foo);
};
