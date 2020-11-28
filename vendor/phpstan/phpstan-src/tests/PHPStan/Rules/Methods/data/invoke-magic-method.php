<?php

namespace _PhpScoperabd03f0baf05\InvokeMagicInvokeMethod;

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
    $foo = new \_PhpScoperabd03f0baf05\InvokeMagicInvokeMethod\ClassForCallable();
    $foo->doFoo(new \_PhpScoperabd03f0baf05\InvokeMagicInvokeMethod\ClassWithInvoke());
    $foo->doFoo($foo);
};
