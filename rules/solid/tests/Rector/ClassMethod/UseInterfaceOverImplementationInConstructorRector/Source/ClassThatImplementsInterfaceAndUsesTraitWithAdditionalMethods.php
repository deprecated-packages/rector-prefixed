<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source;

final class ClassThatImplementsInterfaceAndUsesTraitWithAdditionalMethods implements \_PhpScoperb75b35f52b74\Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source\InterfaceFive
{
    use TraitOne;
    public function methodFromInterface() : void
    {
    }
}
