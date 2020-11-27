<?php

namespace _PhpScoperbd5d0c5f7638\AnonymousClassNameInTrait;

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
