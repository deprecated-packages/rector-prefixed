<?php

namespace _PhpScoperbd5d0c5f7638\UniversalObjectCreates;

class DifferentGetSetTypes
{
    private $values = [];
    public function __get($name) : \_PhpScoperbd5d0c5f7638\UniversalObjectCreates\DifferentGetSetTypesValue
    {
        $this->values[$name] ?: new \_PhpScoperbd5d0c5f7638\UniversalObjectCreates\DifferentGetSetTypesValue();
    }
    public function __set($name, string $value) : void
    {
        $newValue = new \_PhpScoperbd5d0c5f7638\UniversalObjectCreates\DifferentGetSetTypesValue();
        $newValue->value = $value;
        $this->values[$name] = $newValue;
    }
}
class DifferentGetSetTypesValue
{
    public $value = null;
}
