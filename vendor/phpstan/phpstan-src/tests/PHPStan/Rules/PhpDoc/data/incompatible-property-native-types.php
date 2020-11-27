<?php

// lint >= 7.4
namespace _PhpScoper26e51eeacccf\IncompatiblePhpDocPropertyNativeType;

class Foo
{
    /** @var self */
    private object $selfOne;
    /** @var object */
    private \_PhpScoper26e51eeacccf\self $selfTwo;
    /** @var Bar */
    private \_PhpScoper26e51eeacccf\IncompatiblePhpDocPropertyNativeType\Foo $foo;
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
