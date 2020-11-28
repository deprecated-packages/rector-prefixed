<?php

namespace _PhpScoperabd03f0baf05\ClosurePassedByReference;

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
