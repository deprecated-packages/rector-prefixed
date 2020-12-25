<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector\Source;

use _PhpScoperbf340cb0be9d\Doctrine\ORM\Mapping as ORM;
use _PhpScoperbf340cb0be9d\Ramsey\Uuid\UuidInterface;
/**
 * @ORM\Entity
 */
class Car
{
    private $uuid;
    public function getUuid() : \_PhpScoperbf340cb0be9d\Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }
}
