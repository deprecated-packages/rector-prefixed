<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

use _PhpScoper26e51eeacccf\Ramsey\Uuid\Uuid;
use _PhpScoper26e51eeacccf\Ramsey\Uuid\UuidInterface;
final class EntityReturningUuid
{
    public function getId() : \_PhpScoper26e51eeacccf\Ramsey\Uuid\UuidInterface
    {
        return \_PhpScoper26e51eeacccf\Ramsey\Uuid\Uuid::uuid4();
    }
}
