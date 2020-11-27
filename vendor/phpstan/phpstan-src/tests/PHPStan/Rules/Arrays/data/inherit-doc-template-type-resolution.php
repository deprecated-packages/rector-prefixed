<?php

namespace _PhpScoper26e51eeacccf\InheritDocTemplateTypeResolution;

class Foo extends \SimpleXMLElement
{
    public function removeThis() : void
    {
        unset($this[0]);
    }
}
