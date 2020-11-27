<?php

// lint >= 8.0
namespace _PhpScoperbd5d0c5f7638\DuplicatedPromotedProperty;

class Foo
{
    private $foo;
    public function __construct(private $foo, private $bar, private $bar)
    {
    }
}
