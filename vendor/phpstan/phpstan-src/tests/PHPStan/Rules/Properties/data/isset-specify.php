<?php

namespace _PhpScoper006a73f0e455\IssetSpecifyAccessProperty;

class Example
{
    function foo(?\_PhpScoper006a73f0e455\IssetSpecifyAccessProperty\ObjectWithArrayProp $nullableObject) : bool
    {
        return isset($nullableObject, $nullableObject->arrayProperty['key'], $nullableObject->fooProperty['foo']);
    }
}
class ObjectWithArrayProp
{
    /** @var mixed[] */
    public $arrayProperty;
}
