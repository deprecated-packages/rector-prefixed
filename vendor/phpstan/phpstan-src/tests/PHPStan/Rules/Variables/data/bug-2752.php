<?php

namespace _PhpScoper88fe6e0ad041\Bug2572;

class Foo extends \SimpleXMLElement
{
    public function doFoo()
    {
        unset($this[0]);
    }
}
