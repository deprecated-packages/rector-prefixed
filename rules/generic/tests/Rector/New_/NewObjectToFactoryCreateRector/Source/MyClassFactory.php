<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source;

final class MyClassFactory
{
    public function create(string $argument) : \_PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source\MyClass
    {
        return new \_PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source\MyClass($argument);
    }
}
