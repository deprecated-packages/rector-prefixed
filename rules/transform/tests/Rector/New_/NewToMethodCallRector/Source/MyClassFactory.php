<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\New_\NewToMethodCallRector\Source;

final class MyClassFactory
{
    public function create(string $argument) : \Rector\Transform\Tests\Rector\New_\NewToMethodCallRector\Source\MyClass
    {
        return new \Rector\Transform\Tests\Rector\New_\NewToMethodCallRector\Source\MyClass($argument);
    }
}
