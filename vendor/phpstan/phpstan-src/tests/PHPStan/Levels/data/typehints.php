<?php

namespace _PhpScoper88fe6e0ad041\Levels\Typehints;

class Foo
{
    public function doFoo(\_PhpScoper88fe6e0ad041\Levels\Typehints\Lorem $lorem) : \_PhpScoper88fe6e0ad041\Levels\Typehints\Ipsum
    {
        return new \_PhpScoper88fe6e0ad041\Levels\Typehints\Ipsum();
    }
    /**
     * @param Lorem $lorem
     * @return Ipsum
     */
    public function doBar($lorem)
    {
        return new \_PhpScoper88fe6e0ad041\Levels\Typehints\Ipsum();
    }
}
