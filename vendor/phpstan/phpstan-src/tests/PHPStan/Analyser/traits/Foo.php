<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\AnalyseTraits;

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
