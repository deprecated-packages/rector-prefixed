<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

use _PhpScoperfce0de0de1ce\Ramsey\Uuid\Uuid;
use _PhpScoperfce0de0de1ce\Ramsey\Uuid\UuidInterface;
final class EntityReturningUuid
{
    public function getId() : \_PhpScoperfce0de0de1ce\Ramsey\Uuid\UuidInterface
    {
        return \_PhpScoperfce0de0de1ce\Ramsey\Uuid\Uuid::uuid4();
    }
}
