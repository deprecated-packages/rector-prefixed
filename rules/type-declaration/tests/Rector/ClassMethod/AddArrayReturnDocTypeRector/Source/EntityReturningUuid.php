<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

use _PhpScoper267b3276efc2\Ramsey\Uuid\Uuid;
use _PhpScoper267b3276efc2\Ramsey\Uuid\UuidInterface;
final class EntityReturningUuid
{
    public function getId() : \_PhpScoper267b3276efc2\Ramsey\Uuid\UuidInterface
    {
        return \_PhpScoper267b3276efc2\Ramsey\Uuid\Uuid::uuid4();
    }
}
