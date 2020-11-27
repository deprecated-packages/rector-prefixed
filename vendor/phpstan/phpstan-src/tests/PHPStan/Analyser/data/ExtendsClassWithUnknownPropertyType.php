<?php

namespace _PhpScopera143bcca66cb;

class ExtendsClassWithUnknownPropertyType extends \_PhpScopera143bcca66cb\ClassWithUnknownPropertyType
{
    /** @var self */
    private $foo;
    public function doFoo() : void
    {
        $this->foo->foo();
    }
}
\class_alias('_PhpScopera143bcca66cb\\ExtendsClassWithUnknownPropertyType', 'ExtendsClassWithUnknownPropertyType', \false);
