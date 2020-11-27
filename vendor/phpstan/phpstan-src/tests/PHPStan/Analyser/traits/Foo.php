<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\AnalyseTraits;

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
