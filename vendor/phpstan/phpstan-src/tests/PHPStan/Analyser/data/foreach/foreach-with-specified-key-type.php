<?php

namespace _PhpScoper26e51eeacccf\ForeachWithGenericsPhpDoc;

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
