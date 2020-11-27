<?php

namespace _PhpScoper88fe6e0ad041\MixinMethods;

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
function (\_PhpScoper88fe6e0ad041\MixinMethods\Bar $bar) : void {
    $bar->doFoo();
    $bar->doFoo(1);
};
class Baz extends \_PhpScoper88fe6e0ad041\MixinMethods\Bar
{
}
function (\_PhpScoper88fe6e0ad041\MixinMethods\Baz $baz) : void {
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
    public function doFoo(\_PhpScoper88fe6e0ad041\MixinMethods\GenericFoo $foo) : void
    {
        echo $foo->getMessage();
        echo $foo->getMessage(1);
        echo $foo->getMessagee();
    }
}
