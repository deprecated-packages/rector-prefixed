<?php

// lint >= 7.4
namespace _PhpScopera143bcca66cb\IncompatiblePhpDocPropertyNativeType;

class Foo
{
    /** @var self */
    private object $selfOne;
    /** @var object */
    private \_PhpScopera143bcca66cb\self $selfTwo;
    /** @var Bar */
    private \_PhpScopera143bcca66cb\IncompatiblePhpDocPropertyNativeType\Foo $foo;
    /** @var string */
    private string $string;
    /** @var string|int */
    private string $stringOrInt;
    /** @var string */
    private ?string $stringOrNull;
}
class Bar
{
}
class Baz
{
    private string $stringProp;
}
