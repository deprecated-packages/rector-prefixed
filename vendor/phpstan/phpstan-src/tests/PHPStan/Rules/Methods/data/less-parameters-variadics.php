<?php

namespace _PhpScoperbd5d0c5f7638\LessParametersVariadics;

class Foo
{
    public function doFoo(int $many, string $parameters, string $here)
    {
    }
}
class Bar extends \_PhpScoperbd5d0c5f7638\LessParametersVariadics\Foo
{
    public function doFoo(...$everything)
    {
    }
}
class Baz extends \_PhpScoperbd5d0c5f7638\LessParametersVariadics\Foo
{
    public function doFoo(int ...$everything)
    {
    }
}
class Lorem extends \_PhpScoperbd5d0c5f7638\LessParametersVariadics\Foo
{
    public function doFoo(int $many, string ...$everything)
    {
    }
}
