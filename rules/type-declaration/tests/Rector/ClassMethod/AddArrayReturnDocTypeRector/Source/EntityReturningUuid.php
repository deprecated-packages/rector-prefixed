<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

use _PhpScopere8e811afab72\Ramsey\Uuid\Uuid;
use _PhpScopere8e811afab72\Ramsey\Uuid\UuidInterface;
final class EntityReturningUuid
{
    public function getId() : \_PhpScopere8e811afab72\Ramsey\Uuid\UuidInterface
    {
        return \_PhpScopere8e811afab72\Ramsey\Uuid\Uuid::uuid4();
    }
}
