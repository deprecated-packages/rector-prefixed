<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\HasTraitUse;

trait FooTrait
{
    public function variadicMethod()
    {
        if (doFoo()) {
            $args = \func_get_args();
        }
    }
}
