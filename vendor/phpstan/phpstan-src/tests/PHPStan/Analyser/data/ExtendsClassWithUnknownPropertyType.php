<?php

namespace _PhpScoper88fe6e0ad041;

class ExtendsClassWithUnknownPropertyType extends \_PhpScoper88fe6e0ad041\ClassWithUnknownPropertyType
{
    /** @var self */
    private $foo;
    public function doFoo() : void
    {
        $this->foo->foo();
    }
}
\class_alias('_PhpScoper88fe6e0ad041\\ExtendsClassWithUnknownPropertyType', 'ExtendsClassWithUnknownPropertyType', \false);
