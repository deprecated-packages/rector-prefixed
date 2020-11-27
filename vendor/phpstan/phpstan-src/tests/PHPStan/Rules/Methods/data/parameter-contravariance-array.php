<?php

namespace _PhpScoperbd5d0c5f7638\ParameterContravarianceArray;

class Foo
{
    public function doFoo(array $a)
    {
    }
    public function doBar(?array $a)
    {
    }
}
class Bar extends \_PhpScoperbd5d0c5f7638\ParameterContravarianceArray\Foo
{
    public function doFoo(iterable $a)
    {
    }
    public function doBar(?iterable $a)
    {
    }
}
class Baz extends \_PhpScoperbd5d0c5f7638\ParameterContravarianceArray\Foo
{
    public function doFoo(?iterable $a)
    {
    }
    public function doBar(iterable $a)
    {
    }
}
