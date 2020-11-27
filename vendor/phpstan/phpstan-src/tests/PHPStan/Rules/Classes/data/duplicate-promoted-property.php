<?php

// lint >= 8.0
namespace _PhpScopera143bcca66cb\DuplicatedPromotedProperty;

class Foo
{
    private $foo;
    public function __construct(private $foo, private $bar, private $bar)
    {
    }
}
