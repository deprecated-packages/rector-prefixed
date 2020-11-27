<?php

namespace _PhpScoperbd5d0c5f7638\ParameterContravariance;

class Foo
{
    public function doFoo(\Exception $e)
    {
    }
    public function doBar(\InvalidArgumentException $e)
    {
    }
}
class Bar extends \_PhpScoperbd5d0c5f7638\ParameterContravariance\Foo
{
    public function doFoo(?\Exception $e)
    {
    }
    public function doBar(\Exception $e)
    {
    }
}
class Baz extends \_PhpScoperbd5d0c5f7638\ParameterContravariance\Foo
{
    public function doBar(?\Exception $e)
    {
    }
}
class Lorem extends \_PhpScoperbd5d0c5f7638\ParameterContravariance\Foo
{
    public function doFoo(\InvalidArgumentException $e)
    {
    }
}
class Ipsum extends \_PhpScoperbd5d0c5f7638\ParameterContravariance\Foo
{
    public function doFoo(?\InvalidArgumentException $e)
    {
    }
}
