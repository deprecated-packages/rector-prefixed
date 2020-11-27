<?php

namespace _PhpScoper006a73f0e455\ForeachWithGenericsPhpDoc;

class Foo
{
    /**
     * @param iterable<self|Bar, string|int|float> $list
     */
    public function doFoo(iterable $list)
    {
        foreach ($list as $key => $value) {
            die;
        }
    }
}
