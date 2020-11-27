<?php

namespace _PhpScoper006a73f0e455\PropertyArray;

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
