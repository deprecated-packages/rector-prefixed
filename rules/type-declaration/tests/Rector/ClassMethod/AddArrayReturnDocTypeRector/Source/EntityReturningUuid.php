<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

use _PhpScoper006a73f0e455\Ramsey\Uuid\Uuid;
use _PhpScoper006a73f0e455\Ramsey\Uuid\UuidInterface;
final class EntityReturningUuid
{
    public function getId() : \_PhpScoper006a73f0e455\Ramsey\Uuid\UuidInterface
    {
        return \_PhpScoper006a73f0e455\Ramsey\Uuid\Uuid::uuid4();
    }
}
