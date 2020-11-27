<?php

namespace _PhpScoper26e51eeacccf\MixinProperties;

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
function (\_PhpScoper26e51eeacccf\MixinProperties\Bar $bar) : void {
    $bar->fooProp;
};
class Baz extends \_PhpScoper26e51eeacccf\MixinProperties\Bar
{
}
function (\_PhpScoper26e51eeacccf\MixinProperties\Baz $baz) : void {
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
    public function doFoo(\_PhpScoper26e51eeacccf\MixinProperties\GenericFoo $foo) : void
    {
        echo $foo->name;
        echo $foo->namee;
    }
}
