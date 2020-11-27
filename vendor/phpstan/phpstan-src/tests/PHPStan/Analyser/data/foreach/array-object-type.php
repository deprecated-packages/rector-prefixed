<?php

namespace _PhpScopera143bcca66cb\ArrayObjectType;

use _PhpScopera143bcca66cb\AnotherNamespace\Foo;
class Test
{
    const ARRAY_CONSTANT = [0, 1, 2, 3];
    const MIXED_CONSTANT = [0, 'foo'];
    public function doFoo()
    {
        /** @var Foo[] $foos */
        $foos = foos();
        foreach ($foos as $foo) {
            die;
        }
    }
}
