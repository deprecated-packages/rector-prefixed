<?php

// lint >= 7.4
namespace _PhpScoperabd03f0baf05\IncompatiblePhpDocPropertyNativeType;

class Foo
{
    /** @var self */
    private object $selfOne;
    /** @var object */
    private \_PhpScoperabd03f0baf05\self $selfTwo;
    /** @var Bar */
    private \_PhpScoperabd03f0baf05\IncompatiblePhpDocPropertyNativeType\Foo $foo;
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
