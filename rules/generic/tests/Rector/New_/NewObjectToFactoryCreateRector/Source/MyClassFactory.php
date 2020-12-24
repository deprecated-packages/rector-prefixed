<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source;

final class MyClassFactory
{
    public function create(string $argument) : \_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source\MyClass
    {
        return new \_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source\MyClass($argument);
    }
}
