<?php

namespace _PhpScoperabd03f0baf05\MixinProperties;

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
function (\_PhpScoperabd03f0baf05\MixinProperties\Bar $bar) : void {
    $bar->fooProp;
};
class Baz extends \_PhpScoperabd03f0baf05\MixinProperties\Bar
{
}
function (\_PhpScoperabd03f0baf05\MixinProperties\Baz $baz) : void {
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
    public function doFoo(\_PhpScoperabd03f0baf05\MixinProperties\GenericFoo $foo) : void
    {
        echo $foo->name;
        echo $foo->namee;
    }
}
