<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

use _PhpScoperbf340cb0be9d\Ramsey\Uuid\Uuid;
use _PhpScoperbf340cb0be9d\Ramsey\Uuid\UuidInterface;
final class EntityReturningUuid
{
    public function getId() : \_PhpScoperbf340cb0be9d\Ramsey\Uuid\UuidInterface
    {
        return \_PhpScoperbf340cb0be9d\Ramsey\Uuid\Uuid::uuid4();
    }
}
