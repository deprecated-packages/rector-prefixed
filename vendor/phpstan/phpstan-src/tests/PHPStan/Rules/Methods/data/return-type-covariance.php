<?php

namespace _PhpScoperbd5d0c5f7638\ReturnTypeCovariance;

class Foo
{
    public function doFoo() : iterable
    {
    }
    public function doBar() : array
    {
    }
    public function doBaz() : \Exception
    {
    }
    public function doLorem() : \InvalidArgumentException
    {
    }
}
class Bar extends \_PhpScoperbd5d0c5f7638\ReturnTypeCovariance\Foo
{
    public function doFoo() : array
    {
    }
    public function doBar() : iterable
    {
    }
    public function doBaz() : \InvalidArgumentException
    {
    }
    public function doLorem() : \Exception
    {
    }
}
class A
{
    public function foo(string $s) : ?\stdClass
    {
    }
}
class B extends \_PhpScoperbd5d0c5f7638\ReturnTypeCovariance\A
{
    public function foo($s)
    {
        return \rand(0, 1) ? new \_PhpScoperbd5d0c5f7638\ReturnTypeCovariance\stdClass() : null;
    }
}
