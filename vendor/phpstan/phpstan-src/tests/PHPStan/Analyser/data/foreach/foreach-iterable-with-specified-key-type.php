<?php

namespace _PhpScoperabd03f0baf05\ForeachWithGenericsPhpDoc;

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
