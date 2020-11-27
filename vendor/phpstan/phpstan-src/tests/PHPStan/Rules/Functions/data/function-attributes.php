<?php

namespace _PhpScoper88fe6e0ad041\FunctionAttributes;

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
#[Foo]
function doFoo() : void
{
}
#[Bar]
function doBar() : void
{
}
#[Baz]
function doBaz() : void
{
}
