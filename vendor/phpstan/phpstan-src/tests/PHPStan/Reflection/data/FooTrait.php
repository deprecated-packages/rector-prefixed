<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\HasTraitUse;

trait FooTrait
{
    public function variadicMethod()
    {
        if (doFoo()) {
            $args = \func_get_args();
        }
    }
}
