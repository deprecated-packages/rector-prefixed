<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source;

final class ClassThatImplementsInterfaceAndDefinesOwnPublicMethods implements \_PhpScopere8e811afab72\Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source\InterfaceFour
{
    public function foo() : string
    {
        return 'bar';
    }
    public function methodFromInterface() : void
    {
    }
}
