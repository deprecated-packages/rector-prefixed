<?php

// lint >= 8.0
namespace _PhpScoper88fe6e0ad041\ClassConstantOnExpr;

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
