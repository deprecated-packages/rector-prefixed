<?php

namespace _PhpScoper88fe6e0ad041\ClosurePassedByReference;

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
