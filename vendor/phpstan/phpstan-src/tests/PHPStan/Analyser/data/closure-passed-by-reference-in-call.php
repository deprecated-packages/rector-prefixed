<?php

namespace _PhpScopera143bcca66cb\ClosurePassedByReference;

class Foo
{
    public function doFoo(\Closure $closure) : int
    {
        return 5;
    }
    public function doBar()
    {
        $five = $this->doFoo(function () use(&$five) {
            die;
        });
    }
}
