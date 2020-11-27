<?php

namespace _PhpScoper006a73f0e455\ParameterContravarianceArray;

class Foo
{
    public function doFoo(array $a)
    {
    }
    public function doBar(?array $a)
    {
    }
}
class Bar extends \_PhpScoper006a73f0e455\ParameterContravarianceArray\Foo
{
    public function doFoo(iterable $a)
    {
    }
    public function doBar(?iterable $a)
    {
    }
}
class Baz extends \_PhpScoper006a73f0e455\ParameterContravarianceArray\Foo
{
    public function doFoo(?iterable $a)
    {
    }
    public function doBar(iterable $a)
    {
    }
}
