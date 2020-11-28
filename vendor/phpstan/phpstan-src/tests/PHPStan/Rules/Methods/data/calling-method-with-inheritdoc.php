<?php

namespace _PhpScoperabd03f0baf05\MethodWithInheritDoc;

interface FooInterface
{
    /**
     * @param string $str
     */
    public function doBar($str);
}
class Foo implements \_PhpScoperabd03f0baf05\MethodWithInheritDoc\FooInterface
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
class Bar extends \_PhpScoperabd03f0baf05\MethodWithInheritDoc\Foo
{
    /**
     * {@inheritDoc}
     */
    public function doFoo($i)
    {
    }
}
class Baz extends \_PhpScoperabd03f0baf05\MethodWithInheritDoc\Bar
{
    /**
     * {@inheritDoc}
     */
    public function doFoo($i)
    {
    }
}
function () {
    $baz = new \_PhpScoperabd03f0baf05\MethodWithInheritDoc\Baz();
    $baz->doFoo(1);
    $baz->doFoo('1');
    $baz->doBar('1');
    $baz->doBar(1);
};
