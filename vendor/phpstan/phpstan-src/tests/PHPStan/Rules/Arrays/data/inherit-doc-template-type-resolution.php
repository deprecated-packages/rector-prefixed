<?php

namespace _PhpScoperbd5d0c5f7638\InheritDocTemplateTypeResolution;

class Foo extends \SimpleXMLElement
{
    public function removeThis() : void
    {
        unset($this[0]);
    }
}
