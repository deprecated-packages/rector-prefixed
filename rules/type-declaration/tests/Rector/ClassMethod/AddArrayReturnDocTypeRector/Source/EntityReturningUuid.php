<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

use _PhpScoper5b8c9e9ebd21\Ramsey\Uuid\Uuid;
use _PhpScoper5b8c9e9ebd21\Ramsey\Uuid\UuidInterface;
final class EntityReturningUuid
{
    public function getId() : \_PhpScoper5b8c9e9ebd21\Ramsey\Uuid\UuidInterface
    {
        return \_PhpScoper5b8c9e9ebd21\Ramsey\Uuid\Uuid::uuid4();
    }
}
