<?php

// lint >= 8.0
namespace _PhpScopera143bcca66cb\UnusedConstructorParametersPromotedProperties;

class Foo
{
    private int $y;
    public function __construct(public int $x, int $y)
    {
        $this->y = $y;
    }
}
