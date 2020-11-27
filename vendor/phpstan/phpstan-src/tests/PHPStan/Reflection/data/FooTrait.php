<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\HasTraitUse;

trait FooTrait
{
    public function variadicMethod()
    {
        if (doFoo()) {
            $args = \func_get_args();
        }
    }
}
