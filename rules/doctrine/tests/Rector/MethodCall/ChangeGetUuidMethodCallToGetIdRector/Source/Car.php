<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector\Source;

use _PhpScoper5edc98a7cce2\Doctrine\ORM\Mapping as ORM;
use _PhpScoper5edc98a7cce2\Ramsey\Uuid\UuidInterface;
/**
 * @ORM\Entity
 */
class Car
{
    private $uuid;
    public function getUuid() : \_PhpScoper5edc98a7cce2\Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }
}
