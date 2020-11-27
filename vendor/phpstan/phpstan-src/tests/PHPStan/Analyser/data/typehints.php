<?php

namespace _PhpScoperbd5d0c5f7638\TypesNamespaceTypehints;

class Foo
{
    public function doFoo(int $integer, bool $boolean, string $string, float $float, \_PhpScoperbd5d0c5f7638\TypesNamespaceTypehints\Lorem $loremObject, $mixed, array $array, bool $isNullable = null, callable $callable, string ...$variadicStrings) : \_PhpScoperbd5d0c5f7638\TypesNamespaceTypehints\Bar
    {
        $loremObjectRef = $loremObject;
        $barObject = $this->doFoo();
        $fooObject = new self();
        $anotherBarObject = $fooObject->doFoo();
        die;
    }
}
