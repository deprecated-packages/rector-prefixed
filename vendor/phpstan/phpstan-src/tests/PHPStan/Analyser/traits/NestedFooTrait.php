<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\AnalyseTraits;

trait NestedFooTrait
{
    use FooTrait;
    public function doNestedTraitFoo() : void
    {
        $this->doNestedFoo();
    }
}
