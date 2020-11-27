<?php

// lint >= 7.4
namespace _PhpScoperbd5d0c5f7638\IncompatiblePhpDocPropertyNativeType;

class Foo
{
    /** @var self */
    private object $selfOne;
    /** @var object */
    private \_PhpScoperbd5d0c5f7638\self $selfTwo;
    /** @var Bar */
    private \_PhpScoperbd5d0c5f7638\IncompatiblePhpDocPropertyNativeType\Foo $foo;
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
