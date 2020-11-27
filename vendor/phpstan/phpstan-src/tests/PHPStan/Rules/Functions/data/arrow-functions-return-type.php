<?php

// lint >= 7.4
namespace _PhpScoperbd5d0c5f7638\ArrowFunctionsReturnTypes;

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
