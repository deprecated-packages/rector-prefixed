<?php

namespace _PhpScopera143bcca66cb\MethodWithInheritDoc;

interface FooInterface
{
    /**
     * @param string $str
     */
    public function doBar($str);
}
class Foo implements \_PhpScopera143bcca66cb\MethodWithInheritDoc\FooInterface
{
    /**
     * @param int $i
     */
    public function doFoo($i)
    {
    }
    /**
     * {@inheritDoc}
     */
    public function doBar($str)
    {
    }
}
class Bar extends \_PhpScopera143bcca66cb\MethodWithInheritDoc\Foo
{
    /**
     * {@inheritDoc}
     */
    public function doFoo($i)
    {
    }
}
class Baz extends \_PhpScopera143bcca66cb\MethodWithInheritDoc\Bar
{
    /**
     * {@inheritDoc}
     */
    public function doFoo($i)
    {
    }
}
function () {
    $baz = new \_PhpScopera143bcca66cb\MethodWithInheritDoc\Baz();
    $baz->doFoo(1);
    $baz->doFoo('1');
    $baz->doBar('1');
    $baz->doBar(1);
};
