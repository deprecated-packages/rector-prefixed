<?php

namespace _PhpScoper26e51eeacccf\IssetSpecifyAccessProperty;

class Example
{
    function foo(?\_PhpScoper26e51eeacccf\IssetSpecifyAccessProperty\ObjectWithArrayProp $nullableObject) : bool
    {
        return isset($nullableObject, $nullableObject->arrayProperty['key'], $nullableObject->fooProperty['foo']);
    }
}
class ObjectWithArrayProp
{
    /** @var mixed[] */
    public $arrayProperty;
}
