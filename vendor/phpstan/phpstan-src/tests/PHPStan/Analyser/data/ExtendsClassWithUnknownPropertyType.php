<?php

namespace _PhpScoper26e51eeacccf;

class ExtendsClassWithUnknownPropertyType extends \_PhpScoper26e51eeacccf\ClassWithUnknownPropertyType
{
    /** @var self */
    private $foo;
    public function doFoo() : void
    {
        $this->foo->foo();
    }
}
\class_alias('_PhpScoper26e51eeacccf\\ExtendsClassWithUnknownPropertyType', 'ExtendsClassWithUnknownPropertyType', \false);
