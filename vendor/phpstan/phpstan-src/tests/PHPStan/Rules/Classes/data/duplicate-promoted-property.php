<?php

// lint >= 8.0
namespace _PhpScoper88fe6e0ad041\DuplicatedPromotedProperty;

class Foo
{
    private $foo;
    public function __construct(private $foo, private $bar, private $bar)
    {
    }
}
