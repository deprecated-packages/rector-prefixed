<?php

namespace _PhpScoperbd5d0c5f7638\MixinMethods;

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
function (\_PhpScoperbd5d0c5f7638\MixinMethods\Bar $bar) : void {
    $bar->doFoo();
    $bar->doFoo(1);
};
class Baz extends \_PhpScoperbd5d0c5f7638\MixinMethods\Bar
{
}
function (\_PhpScoperbd5d0c5f7638\MixinMethods\Baz $baz) : void {
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
    public function doFoo(\_PhpScoperbd5d0c5f7638\MixinMethods\GenericFoo $foo) : void
    {
        echo $foo->getMessage();
        echo $foo->getMessage(1);
        echo $foo->getMessagee();
    }
}
