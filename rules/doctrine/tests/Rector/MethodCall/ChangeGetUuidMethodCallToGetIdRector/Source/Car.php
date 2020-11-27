<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector\Source;

use _PhpScopera143bcca66cb\Doctrine\ORM\Mapping as ORM;
use _PhpScopera143bcca66cb\Ramsey\Uuid\UuidInterface;
/**
 * @ORM\Entity
 */
class Car
{
    private $uuid;
    public function getUuid() : \_PhpScopera143bcca66cb\Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }
}
