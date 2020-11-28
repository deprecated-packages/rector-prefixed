<?php

namespace _PhpScoperabd03f0baf05\IssetSpecifyAccessProperty;

class Example
{
    function foo(?\_PhpScoperabd03f0baf05\IssetSpecifyAccessProperty\ObjectWithArrayProp $nullableObject) : bool
    {
        return isset($nullableObject, $nullableObject->arrayProperty['key'], $nullableObject->fooProperty['foo']);
    }
}
class ObjectWithArrayProp
{
    /** @var mixed[] */
    public $arrayProperty;
}
