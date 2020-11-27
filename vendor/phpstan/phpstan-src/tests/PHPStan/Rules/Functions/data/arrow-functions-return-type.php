<?php

// lint >= 7.4
namespace _PhpScopera143bcca66cb\ArrowFunctionsReturnTypes;

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
