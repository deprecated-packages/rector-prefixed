<?php

// lint >= 7.4
namespace _PhpScoperbd5d0c5f7638\IssetNativePropertyTypes;

class Foo
{
    public int $hasDefaultValue = 0;
    public int $isAssignedBefore;
    public int $canBeUninitialized;
}
function (\_PhpScoperbd5d0c5f7638\IssetNativePropertyTypes\Foo $foo) : void {
    echo isset($foo->hasDefaultValue) ? $foo->hasDefaultValue : null;
    $foo->isAssignedBefore = 5;
    echo isset($foo->isAssignedBefore) ? $foo->isAssignedBefore : null;
    echo isset($foo->canBeUninitialized) ? $foo->canBeUninitialized : null;
};
