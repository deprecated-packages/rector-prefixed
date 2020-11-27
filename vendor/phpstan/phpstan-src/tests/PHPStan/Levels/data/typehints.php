<?php

namespace _PhpScoperbd5d0c5f7638\Levels\Typehints;

class Foo
{
    public function doFoo(\_PhpScoperbd5d0c5f7638\Levels\Typehints\Lorem $lorem) : \_PhpScoperbd5d0c5f7638\Levels\Typehints\Ipsum
    {
        return new \_PhpScoperbd5d0c5f7638\Levels\Typehints\Ipsum();
    }
    /**
     * @param Lorem $lorem
     * @return Ipsum
     */
    public function doBar($lorem)
    {
        return new \_PhpScoperbd5d0c5f7638\Levels\Typehints\Ipsum();
    }
}
