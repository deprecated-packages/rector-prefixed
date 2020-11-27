<?php

namespace _PhpScoper006a73f0e455\MixinProperties;

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
function (\_PhpScoper006a73f0e455\MixinProperties\Bar $bar) : void {
    $bar->fooProp;
};
class Baz extends \_PhpScoper006a73f0e455\MixinProperties\Bar
{
}
function (\_PhpScoper006a73f0e455\MixinProperties\Baz $baz) : void {
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
    public function doFoo(\_PhpScoper006a73f0e455\MixinProperties\GenericFoo $foo) : void
    {
        echo $foo->name;
        echo $foo->namee;
    }
}
