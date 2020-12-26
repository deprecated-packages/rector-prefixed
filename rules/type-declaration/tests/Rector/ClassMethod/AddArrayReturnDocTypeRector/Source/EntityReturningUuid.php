<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

use RectorPrefix2020DecSat\Ramsey\Uuid\Uuid;
use RectorPrefix2020DecSat\Ramsey\Uuid\UuidInterface;
final class EntityReturningUuid
{
    public function getId() : \RectorPrefix2020DecSat\Ramsey\Uuid\UuidInterface
    {
        return \RectorPrefix2020DecSat\Ramsey\Uuid\Uuid::uuid4();
    }
}
