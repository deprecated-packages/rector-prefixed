<?php

namespace _PhpScopera143bcca66cb\MixinProperties;

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
function (\_PhpScopera143bcca66cb\MixinProperties\Bar $bar) : void {
    $bar->fooProp;
};
class Baz extends \_PhpScopera143bcca66cb\MixinProperties\Bar
{
}
function (\_PhpScopera143bcca66cb\MixinProperties\Baz $baz) : void {
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
    public function doFoo(\_PhpScopera143bcca66cb\MixinProperties\GenericFoo $foo) : void
    {
        echo $foo->name;
        echo $foo->namee;
    }
}
