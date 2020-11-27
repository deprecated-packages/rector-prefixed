<?php

namespace _PhpScoper88fe6e0ad041\UniversalObjectCreates;

class DifferentGetSetTypes
{
    private $values = [];
    public function __get($name) : \_PhpScoper88fe6e0ad041\UniversalObjectCreates\DifferentGetSetTypesValue
    {
        $this->values[$name] ?: new \_PhpScoper88fe6e0ad041\UniversalObjectCreates\DifferentGetSetTypesValue();
    }
    public function __set($name, string $value) : void
    {
        $newValue = new \_PhpScoper88fe6e0ad041\UniversalObjectCreates\DifferentGetSetTypesValue();
        $newValue->value = $value;
        $this->values[$name] = $newValue;
    }
}
class DifferentGetSetTypesValue
{
    public $value = null;
}
