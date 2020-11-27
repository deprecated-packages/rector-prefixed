<?php

namespace _PhpScoper88fe6e0ad041\MixinProperties;

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
function (\_PhpScoper88fe6e0ad041\MixinProperties\Bar $bar) : void {
    $bar->fooProp;
};
class Baz extends \_PhpScoper88fe6e0ad041\MixinProperties\Bar
{
}
function (\_PhpScoper88fe6e0ad041\MixinProperties\Baz $baz) : void {
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
    public function doFoo(\_PhpScoper88fe6e0ad041\MixinProperties\GenericFoo $foo) : void
    {
        echo $foo->name;
        echo $foo->namee;
    }
}
