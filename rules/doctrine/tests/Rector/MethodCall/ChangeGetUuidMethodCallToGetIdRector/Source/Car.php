<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Doctrine\Tests\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector\Source;

use _PhpScopere8e811afab72\Doctrine\ORM\Mapping as ORM;
use _PhpScopere8e811afab72\Ramsey\Uuid\UuidInterface;
/**
 * @ORM\Entity
 */
class Car
{
    private $uuid;
    public function getUuid() : \_PhpScopere8e811afab72\Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }
}
