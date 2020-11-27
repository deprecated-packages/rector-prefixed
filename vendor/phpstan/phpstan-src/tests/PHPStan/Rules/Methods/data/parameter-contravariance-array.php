<?php

namespace _PhpScoper26e51eeacccf\ParameterContravarianceArray;

class Foo
{
    public function doFoo(array $a)
    {
    }
    public function doBar(?array $a)
    {
    }
}
class Bar extends \_PhpScoper26e51eeacccf\ParameterContravarianceArray\Foo
{
    public function doFoo(iterable $a)
    {
    }
    public function doBar(?iterable $a)
    {
    }
}
class Baz extends \_PhpScoper26e51eeacccf\ParameterContravarianceArray\Foo
{
    public function doFoo(?iterable $a)
    {
    }
    public function doBar(iterable $a)
    {
    }
}
