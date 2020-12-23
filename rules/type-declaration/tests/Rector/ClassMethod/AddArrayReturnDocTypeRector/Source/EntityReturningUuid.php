<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

use _PhpScoper0a2ac50786fa\Ramsey\Uuid\Uuid;
use _PhpScoper0a2ac50786fa\Ramsey\Uuid\UuidInterface;
final class EntityReturningUuid
{
    public function getId() : \_PhpScoper0a2ac50786fa\Ramsey\Uuid\UuidInterface
    {
        return \_PhpScoper0a2ac50786fa\Ramsey\Uuid\Uuid::uuid4();
    }
}
