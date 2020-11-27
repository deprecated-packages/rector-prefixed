<?php

namespace _PhpScoper006a73f0e455\AnonymousClassNameInTrait;

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
