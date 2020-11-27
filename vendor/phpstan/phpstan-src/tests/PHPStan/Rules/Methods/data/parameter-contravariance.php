<?php

namespace _PhpScoper006a73f0e455\ParameterContravariance;

class Foo
{
    public function doFoo(\Exception $e)
    {
    }
    public function doBar(\InvalidArgumentException $e)
    {
    }
}
class Bar extends \_PhpScoper006a73f0e455\ParameterContravariance\Foo
{
    public function doFoo(?\Exception $e)
    {
    }
    public function doBar(\Exception $e)
    {
    }
}
class Baz extends \_PhpScoper006a73f0e455\ParameterContravariance\Foo
{
    public function doBar(?\Exception $e)
    {
    }
}
class Lorem extends \_PhpScoper006a73f0e455\ParameterContravariance\Foo
{
    public function doFoo(\InvalidArgumentException $e)
    {
    }
}
class Ipsum extends \_PhpScoper006a73f0e455\ParameterContravariance\Foo
{
    public function doFoo(?\InvalidArgumentException $e)
    {
    }
}
