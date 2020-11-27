<?php

// lint >= 8.0
namespace _PhpScoper88fe6e0ad041\UnusedConstructorParametersPromotedProperties;

class Foo
{
    private int $y;
    public function __construct(public int $x, int $y)
    {
        $this->y = $y;
    }
}
