<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source;

final class ClassThatImplementsInterfaceAndUsesTraitWithAdditionalMethods implements \_PhpScoper0a6b37af0871\Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source\InterfaceFive
{
    use TraitOne;
    public function methodFromInterface() : void
    {
    }
}
