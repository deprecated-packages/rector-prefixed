<?php

namespace _PhpScoper26e51eeacccf\ClosurePassedByReference;

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
