<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source;

final class MyClassFactory
{
    public function create(string $argument) : \_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source\MyClass
    {
        return new \_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source\MyClass($argument);
    }
}
