<?php

namespace _PhpScoper26e51eeacccf\InheritDocWithoutCurlyBracesFromInterface2;

class Foo implements \_PhpScoper26e51eeacccf\InheritDocWithoutCurlyBracesFromInterface2\FooInterface
{
    /**
     * @inheritdoc
     */
    public function doBar($int)
    {
        die;
    }
}
