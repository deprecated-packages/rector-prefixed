<?php

namespace _PhpScopera143bcca66cb\PropertyArray;

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
