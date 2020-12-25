<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

use _PhpScoper567b66d83109\Ramsey\Uuid\Uuid;
use _PhpScoper567b66d83109\Ramsey\Uuid\UuidInterface;
final class EntityReturningUuid
{
    public function getId() : \_PhpScoper567b66d83109\Ramsey\Uuid\UuidInterface
    {
        return \_PhpScoper567b66d83109\Ramsey\Uuid\Uuid::uuid4();
    }
}
