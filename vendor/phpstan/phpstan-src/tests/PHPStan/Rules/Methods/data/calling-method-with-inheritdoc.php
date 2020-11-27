<?php

namespace _PhpScoperbd5d0c5f7638\MethodWithInheritDoc;

interface FooInterface
{
    /**
     * @param string $str
     */
    public function doBar($str);
}
class Foo implements \_PhpScoperbd5d0c5f7638\MethodWithInheritDoc\FooInterface
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
class Bar extends \_PhpScoperbd5d0c5f7638\MethodWithInheritDoc\Foo
{
    /**
     * {@inheritDoc}
     */
    public function doFoo($i)
    {
    }
}
class Baz extends \_PhpScoperbd5d0c5f7638\MethodWithInheritDoc\Bar
{
    /**
     * {@inheritDoc}
     */
    public function doFoo($i)
    {
    }
}
function () {
    $baz = new \_PhpScoperbd5d0c5f7638\MethodWithInheritDoc\Baz();
    $baz->doFoo(1);
    $baz->doFoo('1');
    $baz->doBar('1');
    $baz->doBar(1);
};
