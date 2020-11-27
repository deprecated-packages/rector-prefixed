<?php

// lint >= 7.4
namespace _PhpScoper88fe6e0ad041\IncompatiblePhpDocPropertyNativeType;

class Foo
{
    /** @var self */
    private object $selfOne;
    /** @var object */
    private \_PhpScoper88fe6e0ad041\self $selfTwo;
    /** @var Bar */
    private \_PhpScoper88fe6e0ad041\IncompatiblePhpDocPropertyNativeType\Foo $foo;
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
