<?php

namespace _PhpScopera143bcca66cb\MethodWithInheritDocWithoutCurlyBraces;

interface FooInterface
{
    /**
     * @param string $str
     */
    public function doBar($str);
}
class Foo implements \_PhpScopera143bcca66cb\MethodWithInheritDocWithoutCurlyBraces\FooInterface
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
class Bar extends \_PhpScopera143bcca66cb\MethodWithInheritDocWithoutCurlyBraces\Foo
{
    /**
     * @inheritDoc
     */
    public function doFoo($i)
    {
    }
}
class Baz extends \_PhpScopera143bcca66cb\MethodWithInheritDocWithoutCurlyBraces\Bar
{
    /**
     * @inheritDoc
     */
    public function doFoo($i)
    {
    }
}
function () {
    $baz = new \_PhpScopera143bcca66cb\MethodWithInheritDocWithoutCurlyBraces\Baz();
    $baz->doFoo(1);
    $baz->doFoo('1');
    $baz->doBar('1');
    $baz->doBar(1);
};
