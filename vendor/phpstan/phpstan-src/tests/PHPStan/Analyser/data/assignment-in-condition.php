<?php

namespace _PhpScoper26e51eeacccf\AssignmentInCondition;

class Foo
{
    public function doFoo() : ?self
    {
    }
    public function doBar()
    {
        $foo = new self();
        if (null !== ($bar = $foo->doFoo())) {
            die;
        }
    }
}
