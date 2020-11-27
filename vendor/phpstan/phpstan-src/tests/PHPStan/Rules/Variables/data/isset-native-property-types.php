<?php

// lint >= 7.4
namespace _PhpScoper88fe6e0ad041\IssetNativePropertyTypes;

class Foo
{
    public int $hasDefaultValue = 0;
    public int $isAssignedBefore;
    public int $canBeUninitialized;
}
function (\_PhpScoper88fe6e0ad041\IssetNativePropertyTypes\Foo $foo) : void {
    echo isset($foo->hasDefaultValue) ? $foo->hasDefaultValue : null;
    $foo->isAssignedBefore = 5;
    echo isset($foo->isAssignedBefore) ? $foo->isAssignedBefore : null;
    echo isset($foo->canBeUninitialized) ? $foo->canBeUninitialized : null;
};
