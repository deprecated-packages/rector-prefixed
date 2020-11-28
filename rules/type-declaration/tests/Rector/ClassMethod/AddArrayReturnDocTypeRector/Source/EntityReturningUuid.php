<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

use _PhpScoperabd03f0baf05\Ramsey\Uuid\Uuid;
use _PhpScoperabd03f0baf05\Ramsey\Uuid\UuidInterface;
final class EntityReturningUuid
{
    public function getId() : \_PhpScoperabd03f0baf05\Ramsey\Uuid\UuidInterface
    {
        return \_PhpScoperabd03f0baf05\Ramsey\Uuid\Uuid::uuid4();
    }
}
