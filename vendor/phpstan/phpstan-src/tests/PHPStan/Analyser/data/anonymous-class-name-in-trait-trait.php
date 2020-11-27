<?php

namespace _PhpScopera143bcca66cb\AnonymousClassNameInTrait;

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
