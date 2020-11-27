<?php

namespace _PhpScoperbd5d0c5f7638\InvokeMagicInvokeMethod;

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
    $foo = new \_PhpScoperbd5d0c5f7638\InvokeMagicInvokeMethod\ClassForCallable();
    $foo->doFoo(new \_PhpScoperbd5d0c5f7638\InvokeMagicInvokeMethod\ClassWithInvoke());
    $foo->doFoo($foo);
};
