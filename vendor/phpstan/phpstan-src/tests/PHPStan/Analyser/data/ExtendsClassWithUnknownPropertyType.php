<?php

namespace _PhpScoperabd03f0baf05;

class ExtendsClassWithUnknownPropertyType extends \_PhpScoperabd03f0baf05\ClassWithUnknownPropertyType
{
    /** @var self */
    private $foo;
    public function doFoo() : void
    {
        $this->foo->foo();
    }
}
\class_alias('_PhpScoperabd03f0baf05\\ExtendsClassWithUnknownPropertyType', 'ExtendsClassWithUnknownPropertyType', \false);
