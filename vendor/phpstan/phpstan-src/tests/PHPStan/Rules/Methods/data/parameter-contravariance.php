<?php

namespace _PhpScopera143bcca66cb\ParameterContravariance;

class Foo
{
    public function doFoo(\Exception $e)
    {
    }
    public function doBar(\InvalidArgumentException $e)
    {
    }
}
class Bar extends \_PhpScopera143bcca66cb\ParameterContravariance\Foo
{
    public function doFoo(?\Exception $e)
    {
    }
    public function doBar(\Exception $e)
    {
    }
}
class Baz extends \_PhpScopera143bcca66cb\ParameterContravariance\Foo
{
    public function doBar(?\Exception $e)
    {
    }
}
class Lorem extends \_PhpScopera143bcca66cb\ParameterContravariance\Foo
{
    public function doFoo(\InvalidArgumentException $e)
    {
    }
}
class Ipsum extends \_PhpScopera143bcca66cb\ParameterContravariance\Foo
{
    public function doFoo(?\InvalidArgumentException $e)
    {
    }
}
