<?php

namespace _PhpScoper006a73f0e455\InvokeMagicInvokeMethod;

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
    $foo = new \_PhpScoper006a73f0e455\InvokeMagicInvokeMethod\ClassForCallable();
    $foo->doFoo(new \_PhpScoper006a73f0e455\InvokeMagicInvokeMethod\ClassWithInvoke());
    $foo->doFoo($foo);
};
