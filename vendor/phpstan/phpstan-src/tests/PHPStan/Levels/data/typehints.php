<?php

namespace _PhpScoper26e51eeacccf\Levels\Typehints;

class Foo
{
    public function doFoo(\_PhpScoper26e51eeacccf\Levels\Typehints\Lorem $lorem) : \_PhpScoper26e51eeacccf\Levels\Typehints\Ipsum
    {
        return new \_PhpScoper26e51eeacccf\Levels\Typehints\Ipsum();
    }
    /**
     * @param Lorem $lorem
     * @return Ipsum
     */
    public function doBar($lorem)
    {
        return new \_PhpScoper26e51eeacccf\Levels\Typehints\Ipsum();
    }
}
