<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\AnalyseTraits;

trait NestedFooTrait
{
    use FooTrait;
    public function doNestedTraitFoo() : void
    {
        $this->doNestedFoo();
    }
}
