<?php

namespace _PhpScoper88fe6e0ad041\TypesNamespaceTypehints;

class Foo
{
    public function doFoo(int $integer, bool $boolean, string $string, float $float, \_PhpScoper88fe6e0ad041\TypesNamespaceTypehints\Lorem $loremObject, $mixed, array $array, bool $isNullable = null, callable $callable, string ...$variadicStrings) : \_PhpScoper88fe6e0ad041\TypesNamespaceTypehints\Bar
    {
        $loremObjectRef = $loremObject;
        $barObject = $this->doFoo();
        $fooObject = new self();
        $anotherBarObject = $fooObject->doFoo();
        die;
    }
}
