<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

use _PhpScoperbd5d0c5f7638\Ramsey\Uuid\Uuid;
use _PhpScoperbd5d0c5f7638\Ramsey\Uuid\UuidInterface;
final class EntityReturningUuid
{
    public function getId() : \_PhpScoperbd5d0c5f7638\Ramsey\Uuid\UuidInterface
    {
        return \_PhpScoperbd5d0c5f7638\Ramsey\Uuid\Uuid::uuid4();
    }
}
