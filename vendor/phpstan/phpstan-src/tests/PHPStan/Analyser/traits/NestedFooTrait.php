<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\AnalyseTraits;

trait NestedFooTrait
{
    use FooTrait;
    public function doNestedTraitFoo() : void
    {
        $this->doNestedFoo();
    }
}
