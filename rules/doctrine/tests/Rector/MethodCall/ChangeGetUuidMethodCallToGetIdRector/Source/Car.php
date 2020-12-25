<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector\Source;

use _PhpScoperf18a0c41e2d2\Doctrine\ORM\Mapping as ORM;
use _PhpScoperf18a0c41e2d2\Ramsey\Uuid\UuidInterface;
/**
 * @ORM\Entity
 */
class Car
{
    private $uuid;
    public function getUuid() : \_PhpScoperf18a0c41e2d2\Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }
}
