<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\HasTraitUse;

trait FooTrait
{
    public function variadicMethod()
    {
        if (doFoo()) {
            $args = \func_get_args();
        }
    }
}
