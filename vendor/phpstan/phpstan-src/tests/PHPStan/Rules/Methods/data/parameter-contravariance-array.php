<?php

namespace _PhpScopera143bcca66cb\ParameterContravarianceArray;

class Foo
{
    public function doFoo(array $a)
    {
    }
    public function doBar(?array $a)
    {
    }
}
class Bar extends \_PhpScopera143bcca66cb\ParameterContravarianceArray\Foo
{
    public function doFoo(iterable $a)
    {
    }
    public function doBar(?iterable $a)
    {
    }
}
class Baz extends \_PhpScopera143bcca66cb\ParameterContravarianceArray\Foo
{
    public function doFoo(?iterable $a)
    {
    }
    public function doBar(iterable $a)
    {
    }
}
