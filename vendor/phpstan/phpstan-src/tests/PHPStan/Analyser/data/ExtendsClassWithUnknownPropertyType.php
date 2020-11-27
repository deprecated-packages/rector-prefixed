<?php

namespace _PhpScoperbd5d0c5f7638;

class ExtendsClassWithUnknownPropertyType extends \_PhpScoperbd5d0c5f7638\ClassWithUnknownPropertyType
{
    /** @var self */
    private $foo;
    public function doFoo() : void
    {
        $this->foo->foo();
    }
}
\class_alias('_PhpScoperbd5d0c5f7638\\ExtendsClassWithUnknownPropertyType', 'ExtendsClassWithUnknownPropertyType', \false);
