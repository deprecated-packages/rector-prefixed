<?php

// lint >= 7.4
namespace _PhpScoperbd5d0c5f7638\ArrowFunctionAttributes;

#[\Attribute(\Attribute::TARGET_CLASS)]
class Foo
{
}
#[\Attribute(\Attribute::TARGET_FUNCTION)]
class Bar
{
}
#[\Attribute(\Attribute::TARGET_ALL)]
class Baz
{
}
class Lorem
{
    public function doFoo()
    {
        #[Foo] fn () => 1;
        #[Bar] fn () => 1;
        #[Baz] fn () => 1;
    }
}
