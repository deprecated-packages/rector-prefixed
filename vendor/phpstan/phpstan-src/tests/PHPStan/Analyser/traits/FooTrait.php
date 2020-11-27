<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\AnalyseTraits;

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
