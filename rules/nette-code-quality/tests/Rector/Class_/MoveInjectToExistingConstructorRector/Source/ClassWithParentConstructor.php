<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteCodeQuality\Tests\Rector\Class_\MoveInjectToExistingConstructorRector\Source;

abstract class ClassWithParentConstructor
{
    public function __construct()
    {
        $yes = 'no';
    }
}
