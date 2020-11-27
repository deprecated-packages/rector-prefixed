<?php

namespace _PhpScoper88fe6e0ad041\ParameterContravarianceTraversable;

class Foo
{
    public function doFoo(\Traversable $a)
    {
    }
    public function doBar(?\Traversable $a)
    {
    }
}
class Bar extends \_PhpScoper88fe6e0ad041\ParameterContravarianceTraversable\Foo
{
    public function doFoo(iterable $a)
    {
    }
    public function doBar(?iterable $a)
    {
    }
}
class Baz extends \_PhpScoper88fe6e0ad041\ParameterContravarianceTraversable\Foo
{
    public function doFoo(?iterable $a)
    {
    }
    public function doBar(iterable $a)
    {
    }
}
