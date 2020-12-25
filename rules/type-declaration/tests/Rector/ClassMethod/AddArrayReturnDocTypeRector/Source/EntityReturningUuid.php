<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

use _PhpScoper17db12703726\Ramsey\Uuid\Uuid;
use _PhpScoper17db12703726\Ramsey\Uuid\UuidInterface;
final class EntityReturningUuid
{
    public function getId() : \_PhpScoper17db12703726\Ramsey\Uuid\UuidInterface
    {
        return \_PhpScoper17db12703726\Ramsey\Uuid\Uuid::uuid4();
    }
}
