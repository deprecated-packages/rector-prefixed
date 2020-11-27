<?php

// lint >= 8.0
namespace _PhpScoperbd5d0c5f7638\UnusedConstructorParametersPromotedProperties;

class Foo
{
    private int $y;
    public function __construct(public int $x, int $y)
    {
        $this->y = $y;
    }
}
