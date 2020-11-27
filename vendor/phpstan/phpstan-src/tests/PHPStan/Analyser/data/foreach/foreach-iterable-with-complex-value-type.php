<?php

namespace _PhpScopera143bcca66cb\ForeachWithComplexValueType;

class Foo
{
    /**
     * @param iterable<float|self> $list
     */
    public function doFoo(iterable $list)
    {
        foreach ($list as $value) {
            die;
        }
    }
}
