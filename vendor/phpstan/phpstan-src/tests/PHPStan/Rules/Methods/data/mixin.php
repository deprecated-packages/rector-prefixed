<?php

namespace _PhpScoper006a73f0e455\MixinMethods;

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
function (\_PhpScoper006a73f0e455\MixinMethods\Bar $bar) : void {
    $bar->doFoo();
    $bar->doFoo(1);
};
class Baz extends \_PhpScoper006a73f0e455\MixinMethods\Bar
{
}
function (\_PhpScoper006a73f0e455\MixinMethods\Baz $baz) : void {
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
    public function doFoo(\_PhpScoper006a73f0e455\MixinMethods\GenericFoo $foo) : void
    {
        echo $foo->getMessage();
        echo $foo->getMessage(1);
        echo $foo->getMessagee();
    }
}
