<?php

namespace _PhpScoperbd5d0c5f7638\ParameterContravarianceTraversable;

class Foo
{
    public function doFoo(\Traversable $a)
    {
    }
    public function doBar(?\Traversable $a)
    {
    }
}
class Bar extends \_PhpScoperbd5d0c5f7638\ParameterContravarianceTraversable\Foo
{
    public function doFoo(iterable $a)
    {
    }
    public function doBar(?iterable $a)
    {
    }
}
class Baz extends \_PhpScoperbd5d0c5f7638\ParameterContravarianceTraversable\Foo
{
    public function doFoo(?iterable $a)
    {
    }
    public function doBar(iterable $a)
    {
    }
}
