<?php

namespace _PhpScopera143bcca66cb\InvokeMagicInvokeMethod;

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
    $foo = new \_PhpScopera143bcca66cb\InvokeMagicInvokeMethod\ClassForCallable();
    $foo->doFoo(new \_PhpScopera143bcca66cb\InvokeMagicInvokeMethod\ClassWithInvoke());
    $foo->doFoo($foo);
};
