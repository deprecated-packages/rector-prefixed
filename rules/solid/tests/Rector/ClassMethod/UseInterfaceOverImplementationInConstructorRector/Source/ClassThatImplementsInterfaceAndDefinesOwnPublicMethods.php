<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source;

final class ClassThatImplementsInterfaceAndDefinesOwnPublicMethods implements \_PhpScoperb75b35f52b74\Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source\InterfaceFour
{
    public function foo() : string
    {
        return 'bar';
    }
    public function methodFromInterface() : void
    {
    }
}
