<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

use _PhpScoper0a6b37af0871\Ramsey\Uuid\Uuid;
use _PhpScoper0a6b37af0871\Ramsey\Uuid\UuidInterface;
final class EntityReturningUuid
{
    public function getId() : \_PhpScoper0a6b37af0871\Ramsey\Uuid\UuidInterface
    {
        return \_PhpScoper0a6b37af0871\Ramsey\Uuid\Uuid::uuid4();
    }
}
