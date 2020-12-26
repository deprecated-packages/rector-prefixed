<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddMethodCallBasedParamTypeRector\Source;

use RectorPrefix2020DecSat\Ramsey\Uuid\UuidInterface;
final class Coconut
{
    public function getId() : \RectorPrefix2020DecSat\Ramsey\Uuid\UuidInterface
    {
    }
}
