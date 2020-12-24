<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteCodeQuality\Tests\Rector\Class_\MoveInjectToExistingConstructorRector\Source;

abstract class ClassWithParentConstructor
{
    public function __construct()
    {
        $yes = 'no';
    }
}
