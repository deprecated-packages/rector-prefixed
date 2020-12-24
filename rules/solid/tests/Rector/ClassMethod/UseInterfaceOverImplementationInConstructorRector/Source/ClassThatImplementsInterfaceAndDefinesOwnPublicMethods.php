<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source;

final class ClassThatImplementsInterfaceAndDefinesOwnPublicMethods implements \_PhpScoper0a6b37af0871\Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source\InterfaceFour
{
    public function foo() : string
    {
        return 'bar';
    }
    public function methodFromInterface() : void
    {
    }
}
