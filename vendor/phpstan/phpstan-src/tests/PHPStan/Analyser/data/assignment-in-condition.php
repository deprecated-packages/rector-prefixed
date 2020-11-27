<?php

namespace _PhpScoperbd5d0c5f7638\AssignmentInCondition;

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
