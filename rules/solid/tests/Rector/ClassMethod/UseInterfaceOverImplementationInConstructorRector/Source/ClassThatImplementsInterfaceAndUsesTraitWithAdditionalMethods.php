<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source;

final class ClassThatImplementsInterfaceAndUsesTraitWithAdditionalMethods implements \_PhpScopere8e811afab72\Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source\InterfaceFive
{
    use TraitOne;
    public function methodFromInterface() : void
    {
    }
}
