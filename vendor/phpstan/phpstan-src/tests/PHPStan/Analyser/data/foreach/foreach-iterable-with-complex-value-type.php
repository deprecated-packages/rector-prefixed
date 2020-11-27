<?php

namespace _PhpScoper88fe6e0ad041\ForeachWithComplexValueType;

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
