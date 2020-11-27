<?php

namespace _PhpScoperbd5d0c5f7638\ForeachWithComplexValueType;

class Foo
{
    /**
     * @param (float|self)[] $list
     */
    public function doFoo(array $list)
    {
        foreach ($list as $value) {
            die;
        }
    }
}
