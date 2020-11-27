<?php

namespace _PhpScoper26e51eeacccf\ForeachWithComplexValueType;

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
