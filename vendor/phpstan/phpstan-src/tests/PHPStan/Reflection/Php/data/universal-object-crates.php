<?php

namespace _PhpScoperabd03f0baf05\UniversalObjectCreates;

class DifferentGetSetTypes
{
    private $values = [];
    public function __get($name) : \_PhpScoperabd03f0baf05\UniversalObjectCreates\DifferentGetSetTypesValue
    {
        $this->values[$name] ?: new \_PhpScoperabd03f0baf05\UniversalObjectCreates\DifferentGetSetTypesValue();
    }
    public function __set($name, string $value) : void
    {
        $newValue = new \_PhpScoperabd03f0baf05\UniversalObjectCreates\DifferentGetSetTypesValue();
        $newValue->value = $value;
        $this->values[$name] = $newValue;
    }
}
class DifferentGetSetTypesValue
{
    public $value = null;
}
