<?php

namespace _PhpScoper006a73f0e455\LessParametersVariadics;

class Foo
{
    public function doFoo(int $many, string $parameters, string $here)
    {
    }
}
class Bar extends \_PhpScoper006a73f0e455\LessParametersVariadics\Foo
{
    public function doFoo(...$everything)
    {
    }
}
class Baz extends \_PhpScoper006a73f0e455\LessParametersVariadics\Foo
{
    public function doFoo(int ...$everything)
    {
    }
}
class Lorem extends \_PhpScoper006a73f0e455\LessParametersVariadics\Foo
{
    public function doFoo(int $many, string ...$everything)
    {
    }
}
