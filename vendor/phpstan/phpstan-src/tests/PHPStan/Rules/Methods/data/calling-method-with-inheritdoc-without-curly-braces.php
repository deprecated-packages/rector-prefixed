<?php

namespace _PhpScoper88fe6e0ad041\MethodWithInheritDocWithoutCurlyBraces;

interface FooInterface
{
    /**
     * @param string $str
     */
    public function doBar($str);
}
class Foo implements \_PhpScoper88fe6e0ad041\MethodWithInheritDocWithoutCurlyBraces\FooInterface
{
    /**
     * @param int $i
     */
    public function doFoo($i)
    {
    }
    /**
     * @inheritDoc
     */
    public function doBar($str)
    {
    }
}
class Bar extends \_PhpScoper88fe6e0ad041\MethodWithInheritDocWithoutCurlyBraces\Foo
{
    /**
     * @inheritDoc
     */
    public function doFoo($i)
    {
    }
}
class Baz extends \_PhpScoper88fe6e0ad041\MethodWithInheritDocWithoutCurlyBraces\Bar
{
    /**
     * @inheritDoc
     */
    public function doFoo($i)
    {
    }
}
function () {
    $baz = new \_PhpScoper88fe6e0ad041\MethodWithInheritDocWithoutCurlyBraces\Baz();
    $baz->doFoo(1);
    $baz->doFoo('1');
    $baz->doBar('1');
    $baz->doBar(1);
};
