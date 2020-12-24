<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Tests\Rector\Class_\MoveInjectToExistingConstructorRector\Source;

abstract class ClassWithParentConstructor
{
    public function __construct()
    {
        $yes = 'no';
    }
}
