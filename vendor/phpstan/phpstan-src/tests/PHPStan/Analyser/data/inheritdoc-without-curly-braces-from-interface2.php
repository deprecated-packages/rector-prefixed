<?php

namespace _PhpScoperbd5d0c5f7638\InheritDocWithoutCurlyBracesFromInterface2;

class Foo implements \_PhpScoperbd5d0c5f7638\InheritDocWithoutCurlyBracesFromInterface2\FooInterface
{
    /**
     * @inheritdoc
     */
    public function doBar($int)
    {
        die;
    }
}
