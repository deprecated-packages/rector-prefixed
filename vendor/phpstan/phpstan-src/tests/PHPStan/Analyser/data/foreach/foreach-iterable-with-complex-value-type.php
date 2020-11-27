<?php

namespace _PhpScoperbd5d0c5f7638\ForeachWithComplexValueType;

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
