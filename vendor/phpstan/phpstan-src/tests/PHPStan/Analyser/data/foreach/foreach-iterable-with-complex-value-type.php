<?php

namespace _PhpScoper26e51eeacccf\ForeachWithComplexValueType;

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
