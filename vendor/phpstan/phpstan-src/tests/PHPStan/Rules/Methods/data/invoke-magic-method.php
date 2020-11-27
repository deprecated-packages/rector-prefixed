<?php

namespace _PhpScoper26e51eeacccf\InvokeMagicInvokeMethod;

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
    $foo = new \_PhpScoper26e51eeacccf\InvokeMagicInvokeMethod\ClassForCallable();
    $foo->doFoo(new \_PhpScoper26e51eeacccf\InvokeMagicInvokeMethod\ClassWithInvoke());
    $foo->doFoo($foo);
};
