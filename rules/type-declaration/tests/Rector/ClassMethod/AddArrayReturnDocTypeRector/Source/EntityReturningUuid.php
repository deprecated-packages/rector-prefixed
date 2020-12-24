<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

use _PhpScoperb75b35f52b74\Ramsey\Uuid\Uuid;
use _PhpScoperb75b35f52b74\Ramsey\Uuid\UuidInterface;
final class EntityReturningUuid
{
    public function getId() : \_PhpScoperb75b35f52b74\Ramsey\Uuid\UuidInterface
    {
        return \_PhpScoperb75b35f52b74\Ramsey\Uuid\Uuid::uuid4();
    }
}
