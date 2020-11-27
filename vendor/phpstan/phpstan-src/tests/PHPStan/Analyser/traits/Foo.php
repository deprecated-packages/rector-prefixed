<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\AnalyseTraits;

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
