<?php

namespace _PhpScopera143bcca66cb\TypesNamespaceTypehints;

class Foo
{
    public function doFoo(int $integer, bool $boolean, string $string, float $float, \_PhpScopera143bcca66cb\TypesNamespaceTypehints\Lorem $loremObject, $mixed, array $array, bool $isNullable = null, callable $callable, string ...$variadicStrings) : \_PhpScopera143bcca66cb\TypesNamespaceTypehints\Bar
    {
        $loremObjectRef = $loremObject;
        $barObject = $this->doFoo();
        $fooObject = new self();
        $anotherBarObject = $fooObject->doFoo();
        die;
    }
}
