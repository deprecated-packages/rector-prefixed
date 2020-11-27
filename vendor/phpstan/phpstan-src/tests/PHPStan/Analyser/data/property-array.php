<?php

namespace _PhpScoper88fe6e0ad041\PropertyArray;

class Foo
{
    private $property;
    public function doFoo()
    {
        'start';
        $this->property = [];
        'emptyArray';
        $this->property['foo'] = 1;
        'afterAssignment';
    }
}
