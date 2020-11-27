<?php

namespace _PhpScoperbd5d0c5f7638\Bug2572;

class Foo extends \SimpleXMLElement
{
    public function doFoo()
    {
        unset($this[0]);
    }
}
