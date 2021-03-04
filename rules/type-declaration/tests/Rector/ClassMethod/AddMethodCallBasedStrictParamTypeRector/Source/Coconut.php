<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddMethodCallBasedStrictParamTypeRector\Source;

use RectorPrefix20210304\Ramsey\Uuid\UuidInterface;
final class Coconut
{
    public function getId() : \RectorPrefix20210304\Ramsey\Uuid\UuidInterface
    {
    }
}
