<?php

namespace _PhpScoper26e51eeacccf\ParameterContravarianceTraversable;

class Foo
{
    public function doFoo(\Traversable $a)
    {
    }
    public function doBar(?\Traversable $a)
    {
    }
}
class Bar extends \_PhpScoper26e51eeacccf\ParameterContravarianceTraversable\Foo
{
    public function doFoo(iterable $a)
    {
    }
    public function doBar(?iterable $a)
    {
    }
}
class Baz extends \_PhpScoper26e51eeacccf\ParameterContravarianceTraversable\Foo
{
    public function doFoo(?iterable $a)
    {
    }
    public function doBar(iterable $a)
    {
    }
}
