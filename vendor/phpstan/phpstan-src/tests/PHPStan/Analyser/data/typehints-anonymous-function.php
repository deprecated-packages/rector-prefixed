<?php

namespace _PhpScoper006a73f0e455\TypesNamespaceTypehints;

class FooWithAnonymousFunction
{
    public function doFoo()
    {
        function (int $integer, bool $boolean, string $string, float $float, \_PhpScoper006a73f0e455\TypesNamespaceTypehints\Lorem $loremObject, $mixed, array $array, bool $isNullable = Null, callable $callable, self $self) {
            die;
        };
    }
}
