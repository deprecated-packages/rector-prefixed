<?php

// lint >= 8.0
namespace _PhpScoper26e51eeacccf\UnusedConstructorParametersPromotedProperties;

class Foo
{
    private int $y;
    public function __construct(public int $x, int $y)
    {
        $this->y = $y;
    }
}
