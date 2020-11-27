<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\AnalyseTraits;

trait NestedFooTrait
{
    use FooTrait;
    public function doNestedTraitFoo() : void
    {
        $this->doNestedFoo();
    }
}
