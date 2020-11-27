<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\HasTraitUse;

trait FooTrait
{
    public function variadicMethod()
    {
        if (doFoo()) {
            $args = \func_get_args();
        }
    }
}
