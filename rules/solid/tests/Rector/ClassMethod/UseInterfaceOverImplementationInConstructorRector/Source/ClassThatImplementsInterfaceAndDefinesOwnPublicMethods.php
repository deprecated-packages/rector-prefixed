<?php

declare (strict_types=1);
namespace Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source;

final class ClassThatImplementsInterfaceAndDefinesOwnPublicMethods implements \Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source\InterfaceFour
{
    public function foo() : string
    {
        return 'bar';
    }
    public function methodFromInterface() : void
    {
    }
}
