<?php

namespace _PhpScoper88fe6e0ad041\ParameterContravarianceArray;

class Foo
{
    public function doFoo(array $a)
    {
    }
    public function doBar(?array $a)
    {
    }
}
class Bar extends \_PhpScoper88fe6e0ad041\ParameterContravarianceArray\Foo
{
    public function doFoo(iterable $a)
    {
    }
    public function doBar(?iterable $a)
    {
    }
}
class Baz extends \_PhpScoper88fe6e0ad041\ParameterContravarianceArray\Foo
{
    public function doFoo(?iterable $a)
    {
    }
    public function doBar(iterable $a)
    {
    }
}
