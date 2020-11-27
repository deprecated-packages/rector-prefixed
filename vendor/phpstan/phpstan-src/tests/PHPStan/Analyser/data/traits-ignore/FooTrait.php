<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\TraitsIgnore;

trait FooTrait
{
    public function doFoo() : void
    {
        fail();
    }
}
