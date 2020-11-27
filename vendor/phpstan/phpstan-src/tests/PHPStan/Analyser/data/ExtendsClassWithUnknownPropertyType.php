<?php

namespace _PhpScoper006a73f0e455;

class ExtendsClassWithUnknownPropertyType extends \_PhpScoper006a73f0e455\ClassWithUnknownPropertyType
{
    /** @var self */
    private $foo;
    public function doFoo() : void
    {
        $this->foo->foo();
    }
}
\class_alias('_PhpScoper006a73f0e455\\ExtendsClassWithUnknownPropertyType', 'ExtendsClassWithUnknownPropertyType', \false);
