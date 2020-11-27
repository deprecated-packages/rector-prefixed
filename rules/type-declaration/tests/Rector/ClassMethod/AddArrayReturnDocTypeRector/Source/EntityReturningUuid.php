<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

use _PhpScoper88fe6e0ad041\Ramsey\Uuid\Uuid;
use _PhpScoper88fe6e0ad041\Ramsey\Uuid\UuidInterface;
final class EntityReturningUuid
{
    public function getId() : \_PhpScoper88fe6e0ad041\Ramsey\Uuid\UuidInterface
    {
        return \_PhpScoper88fe6e0ad041\Ramsey\Uuid\Uuid::uuid4();
    }
}
