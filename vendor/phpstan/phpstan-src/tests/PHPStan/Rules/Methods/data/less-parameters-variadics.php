<?php

namespace _PhpScopera143bcca66cb\LessParametersVariadics;

class Foo
{
    public function doFoo(int $many, string $parameters, string $here)
    {
    }
}
class Bar extends \_PhpScopera143bcca66cb\LessParametersVariadics\Foo
{
    public function doFoo(...$everything)
    {
    }
}
class Baz extends \_PhpScopera143bcca66cb\LessParametersVariadics\Foo
{
    public function doFoo(int ...$everything)
    {
    }
}
class Lorem extends \_PhpScopera143bcca66cb\LessParametersVariadics\Foo
{
    public function doFoo(int $many, string ...$everything)
    {
    }
}
