<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

use _PhpScoperf18a0c41e2d2\Ramsey\Uuid\Uuid;
use _PhpScoperf18a0c41e2d2\Ramsey\Uuid\UuidInterface;
final class EntityReturningUuid
{
    public function getId() : \_PhpScoperf18a0c41e2d2\Ramsey\Uuid\UuidInterface
    {
        return \_PhpScoperf18a0c41e2d2\Ramsey\Uuid\Uuid::uuid4();
    }
}
