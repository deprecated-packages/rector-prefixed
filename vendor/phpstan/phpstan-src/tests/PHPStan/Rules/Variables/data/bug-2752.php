<?php

namespace _PhpScopera143bcca66cb\Bug2572;

class Foo extends \SimpleXMLElement
{
    public function doFoo()
    {
        unset($this[0]);
    }
}
