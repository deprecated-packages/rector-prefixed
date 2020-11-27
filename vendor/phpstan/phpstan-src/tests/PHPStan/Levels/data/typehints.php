<?php

namespace _PhpScopera143bcca66cb\Levels\Typehints;

class Foo
{
    public function doFoo(\_PhpScopera143bcca66cb\Levels\Typehints\Lorem $lorem) : \_PhpScopera143bcca66cb\Levels\Typehints\Ipsum
    {
        return new \_PhpScopera143bcca66cb\Levels\Typehints\Ipsum();
    }
    /**
     * @param Lorem $lorem
     * @return Ipsum
     */
    public function doBar($lorem)
    {
        return new \_PhpScopera143bcca66cb\Levels\Typehints\Ipsum();
    }
}
