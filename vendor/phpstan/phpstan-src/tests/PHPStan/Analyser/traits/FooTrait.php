<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\AnalyseTraits;

trait FooTrait
{
    public function doTraitFoo() : void
    {
        $this->doFoo();
    }
    public function conflictingMethodWithDifferentArgumentNames(string $string) : void
    {
        $r = \strpos($string, 'foo');
    }
}
