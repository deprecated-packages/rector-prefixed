<?php

namespace _PhpScoper26e51eeacccf\ForeachWithGenericsPhpDoc;

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
