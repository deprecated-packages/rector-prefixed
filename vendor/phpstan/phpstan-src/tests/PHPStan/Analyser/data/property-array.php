<?php

namespace _PhpScoperbd5d0c5f7638\PropertyArray;

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
