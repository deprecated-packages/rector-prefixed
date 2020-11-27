<?php

namespace _PhpScopera143bcca66cb\InheritDocTemplateTypeResolution;

class Foo extends \SimpleXMLElement
{
    public function removeThis() : void
    {
        unset($this[0]);
    }
}
