<?php

namespace _PhpScoperabd03f0baf05\ParameterContravarianceTraversable;

class Foo
{
    public function doFoo(\Traversable $a)
    {
    }
    public function doBar(?\Traversable $a)
    {
    }
}
class Bar extends \_PhpScoperabd03f0baf05\ParameterContravarianceTraversable\Foo
{
    public function doFoo(iterable $a)
    {
    }
    public function doBar(?iterable $a)
    {
    }
}
class Baz extends \_PhpScoperabd03f0baf05\ParameterContravarianceTraversable\Foo
{
    public function doFoo(?iterable $a)
    {
    }
    public function doBar(iterable $a)
    {
    }
}
