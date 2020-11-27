<?php

namespace _PhpScoperbd5d0c5f7638\IssetSpecifyAccessProperty;

class Example
{
    function foo(?\_PhpScoperbd5d0c5f7638\IssetSpecifyAccessProperty\ObjectWithArrayProp $nullableObject) : bool
    {
        return isset($nullableObject, $nullableObject->arrayProperty['key'], $nullableObject->fooProperty['foo']);
    }
}
class ObjectWithArrayProp
{
    /** @var mixed[] */
    public $arrayProperty;
}
