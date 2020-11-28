<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\AnalyseTraits;

trait NestedFooTrait
{
    use FooTrait;
    public function doNestedTraitFoo() : void
    {
        $this->doNestedFoo();
    }
}
