<?php

namespace _PhpScopera143bcca66cb\AssignmentInCondition;

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
