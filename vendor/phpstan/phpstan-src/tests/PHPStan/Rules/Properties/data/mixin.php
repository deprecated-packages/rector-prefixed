<?php

namespace _PhpScoperbd5d0c5f7638\MixinProperties;

class Foo
{
    public $fooProp;
}
/**
 * @mixin Foo
 */
class Bar
{
}
function (\_PhpScoperbd5d0c5f7638\MixinProperties\Bar $bar) : void {
    $bar->fooProp;
};
class Baz extends \_PhpScoperbd5d0c5f7638\MixinProperties\Bar
{
}
function (\_PhpScoperbd5d0c5f7638\MixinProperties\Baz $baz) : void {
    $baz->fooProp;
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
     * @param GenericFoo<\ReflectionClass> $foo
     */
    public function doFoo(\_PhpScoperbd5d0c5f7638\MixinProperties\GenericFoo $foo) : void
    {
        echo $foo->name;
        echo $foo->namee;
    }
}
