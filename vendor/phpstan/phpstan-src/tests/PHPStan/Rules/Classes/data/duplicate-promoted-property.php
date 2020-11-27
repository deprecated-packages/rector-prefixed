<?php

// lint >= 8.0
namespace _PhpScoper26e51eeacccf\DuplicatedPromotedProperty;

class Foo
{
    private $foo;
    public function __construct(private $foo, private $bar, private $bar)
    {
    }
}
