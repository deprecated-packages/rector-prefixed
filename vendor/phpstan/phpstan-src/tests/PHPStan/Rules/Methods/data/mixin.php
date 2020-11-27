<?php

namespace _PhpScopera143bcca66cb\MixinMethods;

class Foo
{
    public function doFoo()
    {
    }
}
/**
 * @mixin Foo
 */
class Bar
{
    public function doBar()
    {
    }
}
function (\_PhpScopera143bcca66cb\MixinMethods\Bar $bar) : void {
    $bar->doFoo();
    $bar->doFoo(1);
};
class Baz extends \_PhpScopera143bcca66cb\MixinMethods\Bar
{
}
function (\_PhpScopera143bcca66cb\MixinMethods\Baz $baz) : void {
    $baz->doFoo();
    $baz->doFoo(1);
};
/**
 * @template T
 * @mixin T
 */
class GenericFoo
{
}
class Test
{
    /**
     * @param GenericFoo<\Exception> $foo
     */
    public function doFoo(\_PhpScopera143bcca66cb\MixinMethods\GenericFoo $foo) : void
    {
        echo $foo->getMessage();
        echo $foo->getMessage(1);
        echo $foo->getMessagee();
    }
}
