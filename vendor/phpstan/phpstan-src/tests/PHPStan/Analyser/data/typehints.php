<?php

namespace _PhpScoper006a73f0e455\TypesNamespaceTypehints;

class Foo
{
    public function doFoo(int $integer, bool $boolean, string $string, float $float, \_PhpScoper006a73f0e455\TypesNamespaceTypehints\Lorem $loremObject, $mixed, array $array, bool $isNullable = null, callable $callable, string ...$variadicStrings) : \_PhpScoper006a73f0e455\TypesNamespaceTypehints\Bar
    {
        $loremObjectRef = $loremObject;
        $barObject = $this->doFoo();
        $fooObject = new self();
        $anotherBarObject = $fooObject->doFoo();
        die;
    }
}
