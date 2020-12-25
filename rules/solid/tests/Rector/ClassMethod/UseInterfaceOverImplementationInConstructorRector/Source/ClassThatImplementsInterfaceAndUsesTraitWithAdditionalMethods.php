<?php

declare (strict_types=1);
namespace Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source;

final class ClassThatImplementsInterfaceAndUsesTraitWithAdditionalMethods implements \Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source\InterfaceFive
{
    use TraitOne;
    public function methodFromInterface() : void
    {
    }
}
