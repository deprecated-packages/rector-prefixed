<?php

namespace _PhpScopera143bcca66cb\UniversalObjectCreates;

class DifferentGetSetTypes
{
    private $values = [];
    public function __get($name) : \_PhpScopera143bcca66cb\UniversalObjectCreates\DifferentGetSetTypesValue
    {
        $this->values[$name] ?: new \_PhpScopera143bcca66cb\UniversalObjectCreates\DifferentGetSetTypesValue();
    }
    public function __set($name, string $value) : void
    {
        $newValue = new \_PhpScopera143bcca66cb\UniversalObjectCreates\DifferentGetSetTypesValue();
        $newValue->value = $value;
        $this->values[$name] = $newValue;
    }
}
class DifferentGetSetTypesValue
{
    public $value = null;
}
