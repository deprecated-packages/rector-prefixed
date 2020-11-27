<?php

namespace _PhpScoper006a73f0e455\Levels\Typehints;

class Foo
{
    public function doFoo(\_PhpScoper006a73f0e455\Levels\Typehints\Lorem $lorem) : \_PhpScoper006a73f0e455\Levels\Typehints\Ipsum
    {
        return new \_PhpScoper006a73f0e455\Levels\Typehints\Ipsum();
    }
    /**
     * @param Lorem $lorem
     * @return Ipsum
     */
    public function doBar($lorem)
    {
        return new \_PhpScoper006a73f0e455\Levels\Typehints\Ipsum();
    }
}
