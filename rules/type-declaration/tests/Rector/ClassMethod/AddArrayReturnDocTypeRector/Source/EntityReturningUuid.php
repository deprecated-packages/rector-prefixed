<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

use _PhpScoper5edc98a7cce2\Ramsey\Uuid\Uuid;
use _PhpScoper5edc98a7cce2\Ramsey\Uuid\UuidInterface;
final class EntityReturningUuid
{
    public function getId() : \_PhpScoper5edc98a7cce2\Ramsey\Uuid\UuidInterface
    {
        return \_PhpScoper5edc98a7cce2\Ramsey\Uuid\Uuid::uuid4();
    }
}
