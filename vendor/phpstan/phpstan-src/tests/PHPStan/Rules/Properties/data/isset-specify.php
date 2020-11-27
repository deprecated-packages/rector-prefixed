<?php

namespace _PhpScopera143bcca66cb\IssetSpecifyAccessProperty;

class Example
{
    function foo(?\_PhpScopera143bcca66cb\IssetSpecifyAccessProperty\ObjectWithArrayProp $nullableObject) : bool
    {
        return isset($nullableObject, $nullableObject->arrayProperty['key'], $nullableObject->fooProperty['foo']);
    }
}
class ObjectWithArrayProp
{
    /** @var mixed[] */
    public $arrayProperty;
}
