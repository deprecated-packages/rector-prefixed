<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

use _PhpScopera143bcca66cb\Ramsey\Uuid\Uuid;
use _PhpScopera143bcca66cb\Ramsey\Uuid\UuidInterface;
final class EntityReturningUuid
{
    public function getId() : \_PhpScopera143bcca66cb\Ramsey\Uuid\UuidInterface
    {
        return \_PhpScopera143bcca66cb\Ramsey\Uuid\Uuid::uuid4();
    }
}
