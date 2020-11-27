<?php

namespace _PhpScoper88fe6e0ad041\IssetSpecifyAccessProperty;

class Example
{
    function foo(?\_PhpScoper88fe6e0ad041\IssetSpecifyAccessProperty\ObjectWithArrayProp $nullableObject) : bool
    {
        return isset($nullableObject, $nullableObject->arrayProperty['key'], $nullableObject->fooProperty['foo']);
    }
}
class ObjectWithArrayProp
{
    /** @var mixed[] */
    public $arrayProperty;
}
