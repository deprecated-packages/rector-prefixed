<?php

// lint >= 7.4
namespace _PhpScoper006a73f0e455\ArrowFunctionsReturnTypes;

class Foo
{
    public function doFoo(int $i)
    {
        fn() => $i;
        fn(): int => $i;
        fn(): string => $i;
        fn(int $a): int => $a;
        fn(string $a): int => $a;
    }
}
