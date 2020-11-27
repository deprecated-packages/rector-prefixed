<?php

namespace _PhpScoper006a73f0e455\UniversalObjectCreates;

class DifferentGetSetTypes
{
    private $values = [];
    public function __get($name) : \_PhpScoper006a73f0e455\UniversalObjectCreates\DifferentGetSetTypesValue
    {
        $this->values[$name] ?: new \_PhpScoper006a73f0e455\UniversalObjectCreates\DifferentGetSetTypesValue();
    }
    public function __set($name, string $value) : void
    {
        $newValue = new \_PhpScoper006a73f0e455\UniversalObjectCreates\DifferentGetSetTypesValue();
        $newValue->value = $value;
        $this->values[$name] = $newValue;
    }
}
class DifferentGetSetTypesValue
{
    public $value = null;
}
