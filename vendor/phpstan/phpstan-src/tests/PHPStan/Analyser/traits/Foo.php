<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\AnalyseTraits;

class Foo
{
    use FooTrait;
    public function doFoo() : void
    {
    }
    public function conflictingMethodWithDifferentArgumentNames(string $input) : void
    {
    }
}
