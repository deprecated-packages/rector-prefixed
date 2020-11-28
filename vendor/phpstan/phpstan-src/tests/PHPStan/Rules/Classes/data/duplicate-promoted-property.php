<?php

// lint >= 8.0
namespace _PhpScoperabd03f0baf05\DuplicatedPromotedProperty;

class Foo
{
    private $foo;
    public function __construct(private $foo, private $bar, private $bar)
    {
    }
}
