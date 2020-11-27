<?php

namespace _PhpScoper26e51eeacccf\MethodWithInheritDocWithoutCurlyBraces;

interface FooInterface
{
    /**
     * @param string $str
     */
    public function doBar($str);
}
class Foo implements \_PhpScoper26e51eeacccf\MethodWithInheritDocWithoutCurlyBraces\FooInterface
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
class Bar extends \_PhpScoper26e51eeacccf\MethodWithInheritDocWithoutCurlyBraces\Foo
{
    /**
     * @inheritDoc
     */
    public function doFoo($i)
    {
    }
}
class Baz extends \_PhpScoper26e51eeacccf\MethodWithInheritDocWithoutCurlyBraces\Bar
{
    /**
     * @inheritDoc
     */
    public function doFoo($i)
    {
    }
}
function () {
    $baz = new \_PhpScoper26e51eeacccf\MethodWithInheritDocWithoutCurlyBraces\Baz();
    $baz->doFoo(1);
    $baz->doFoo('1');
    $baz->doBar('1');
    $baz->doBar(1);
};
