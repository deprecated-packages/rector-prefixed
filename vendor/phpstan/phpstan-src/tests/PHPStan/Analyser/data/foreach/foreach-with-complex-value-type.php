<?php

namespace _PhpScoperabd03f0baf05\ForeachWithComplexValueType;

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
