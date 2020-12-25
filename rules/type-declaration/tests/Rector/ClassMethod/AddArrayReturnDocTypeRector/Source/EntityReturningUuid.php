<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

use _PhpScoper8b9c402c5f32\Ramsey\Uuid\Uuid;
use _PhpScoper8b9c402c5f32\Ramsey\Uuid\UuidInterface;
final class EntityReturningUuid
{
    public function getId() : \_PhpScoper8b9c402c5f32\Ramsey\Uuid\UuidInterface
    {
        return \_PhpScoper8b9c402c5f32\Ramsey\Uuid\Uuid::uuid4();
    }
}
