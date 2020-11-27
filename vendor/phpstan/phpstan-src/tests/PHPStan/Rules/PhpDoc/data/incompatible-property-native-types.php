<?php

// lint >= 7.4
namespace _PhpScoper006a73f0e455\IncompatiblePhpDocPropertyNativeType;

class Foo
{
    /** @var self */
    private object $selfOne;
    /** @var object */
    private \_PhpScoper006a73f0e455\self $selfTwo;
    /** @var Bar */
    private \_PhpScoper006a73f0e455\IncompatiblePhpDocPropertyNativeType\Foo $foo;
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
