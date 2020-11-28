<?php

namespace _PhpScoperabd03f0baf05\Levels\Typehints;

class Foo
{
    public function doFoo(\_PhpScoperabd03f0baf05\Levels\Typehints\Lorem $lorem) : \_PhpScoperabd03f0baf05\Levels\Typehints\Ipsum
    {
        return new \_PhpScoperabd03f0baf05\Levels\Typehints\Ipsum();
    }
    /**
     * @param Lorem $lorem
     * @return Ipsum
     */
    public function doBar($lorem)
    {
        return new \_PhpScoperabd03f0baf05\Levels\Typehints\Ipsum();
    }
}
