<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

use _PhpScoper2a4e7ab1ecbc\Ramsey\Uuid\Uuid;
use _PhpScoper2a4e7ab1ecbc\Ramsey\Uuid\UuidInterface;
final class EntityReturningUuid
{
    public function getId() : \_PhpScoper2a4e7ab1ecbc\Ramsey\Uuid\UuidInterface
    {
        return \_PhpScoper2a4e7ab1ecbc\Ramsey\Uuid\Uuid::uuid4();
    }
}
