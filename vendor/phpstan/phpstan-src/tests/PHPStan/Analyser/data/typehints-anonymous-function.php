<?php

namespace _PhpScoper26e51eeacccf\TypesNamespaceTypehints;

class FooWithAnonymousFunction
{
    public function doFoo()
    {
        function (int $integer, bool $boolean, string $string, float $float, \_PhpScoper26e51eeacccf\TypesNamespaceTypehints\Lorem $loremObject, $mixed, array $array, bool $isNullable = Null, callable $callable, self $self) {
            die;
        };
    }
}
