<?php

// lint >= 8.0
namespace _PhpScopera143bcca66cb\ClassConstantOnExpr;

class Foo
{
    public function doFoo(\stdClass $std, string $string, ?\stdClass $stdOrNull, ?string $stringOrNull) : void
    {
        echo $std::class;
        echo $string::class;
        echo $stdOrNull::class;
        echo $stringOrNull::class;
    }
}
