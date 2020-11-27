<?php

namespace _PhpScoper88fe6e0ad041\LessParametersVariadics;

class Foo
{
    public function doFoo(int $many, string $parameters, string $here)
    {
    }
}
class Bar extends \_PhpScoper88fe6e0ad041\LessParametersVariadics\Foo
{
    public function doFoo(...$everything)
    {
    }
}
class Baz extends \_PhpScoper88fe6e0ad041\LessParametersVariadics\Foo
{
    public function doFoo(int ...$everything)
    {
    }
}
class Lorem extends \_PhpScoper88fe6e0ad041\LessParametersVariadics\Foo
{
    public function doFoo(int $many, string ...$everything)
    {
    }
}
