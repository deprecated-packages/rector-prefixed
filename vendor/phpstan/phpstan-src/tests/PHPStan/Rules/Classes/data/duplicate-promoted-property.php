<?php

// lint >= 8.0
namespace _PhpScoper006a73f0e455\DuplicatedPromotedProperty;

class Foo
{
    private $foo;
    public function __construct(private $foo, private $bar, private $bar)
    {
    }
}
