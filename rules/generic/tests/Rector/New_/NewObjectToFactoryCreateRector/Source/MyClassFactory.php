<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source;

final class MyClassFactory
{
    public function create(string $argument) : \_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source\MyClass
    {
        return new \_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source\MyClass($argument);
    }
}
