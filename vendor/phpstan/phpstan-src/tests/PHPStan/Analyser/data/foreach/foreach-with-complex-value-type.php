<?php

namespace _PhpScoper88fe6e0ad041\ForeachWithComplexValueType;

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
