<?php

namespace _PhpScoper88fe6e0ad041\InheritDocTemplateTypeResolution;

class Foo extends \SimpleXMLElement
{
    public function removeThis() : void
    {
        unset($this[0]);
    }
}
