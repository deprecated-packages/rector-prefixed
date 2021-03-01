<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

use RectorPrefix20210301\Ramsey\Uuid\Uuid;
use RectorPrefix20210301\Ramsey\Uuid\UuidInterface;
final class EntityReturningUuid
{
    public function getId() : \RectorPrefix20210301\Ramsey\Uuid\UuidInterface
    {
        return \RectorPrefix20210301\Ramsey\Uuid\Uuid::uuid4();
    }
}
