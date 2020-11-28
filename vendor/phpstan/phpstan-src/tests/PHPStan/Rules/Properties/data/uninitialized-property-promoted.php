<?php

// lint >= 8.0
namespace _PhpScoperabd03f0baf05\UninitializedPropertyPromoted;

class Foo
{
    private int $x;
    public function __construct(private int $y)
    {
        $this->x = $this->y;
    }
}
class Bar
{
    public function __construct(private int $x)
    {
    }
}
class Baz
{
    public function __construct(private int $x)
    {
        \assert($this->x >= 0.0);
    }
}
