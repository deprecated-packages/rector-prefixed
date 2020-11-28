<?php

namespace _PhpScoperabd03f0baf05\AnonymousClassNameInTrait;

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
