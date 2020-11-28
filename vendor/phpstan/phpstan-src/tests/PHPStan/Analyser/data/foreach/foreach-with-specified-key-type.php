<?php

namespace _PhpScoperabd03f0baf05\ForeachWithGenericsPhpDoc;

class Foo
{
    /**
     * @param array<string, string|int|float> $list
     */
    public function doFoo(array $list)
    {
        foreach ($list as $key => $value) {
            die;
        }
    }
}
