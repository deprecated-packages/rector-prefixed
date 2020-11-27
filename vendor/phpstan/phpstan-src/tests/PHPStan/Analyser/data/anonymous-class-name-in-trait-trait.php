<?php

namespace _PhpScoper26e51eeacccf\AnonymousClassNameInTrait;

trait FooTrait
{
    public function doFoo()
    {
        new class
        {
            public function doFoo()
            {
                die;
            }
        };
    }
}
