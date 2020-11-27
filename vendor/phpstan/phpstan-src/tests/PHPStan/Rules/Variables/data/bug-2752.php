<?php

namespace _PhpScoper006a73f0e455\Bug2572;

class Foo extends \SimpleXMLElement
{
    public function doFoo()
    {
        unset($this[0]);
    }
}
